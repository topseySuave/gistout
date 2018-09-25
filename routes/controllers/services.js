/**
 * Created by Daniel on 7/1/2017.
 */

'use strict';

var DURATION_IN_SECONDS = {
    epochs: ['year', 'month', 'day', 'hour', 'minute'],
    year: 31536000,
    month: 2592000,
    day: 86400,
    hour: 3600,
    minute: 60
};

var o = {
    type: 'GET',
    url: '',
    headers: {'Content-Type': 'application/json'}
};

function getDuration(seconds) {
    var epoch, interval;

    for (var i = 0; i < DURATION_IN_SECONDS.epochs.length; i++) {
        epoch = DURATION_IN_SECONDS.epochs[i];
        interval = Math.floor(seconds / DURATION_IN_SECONDS[epoch]);
        if (interval >= 1) {
            return {
                interval: interval,
                epoch: epoch
            };
        }
    }
}

function http(data, $http){
    return $http(data).then(successResponse, errorResponse);
}


function successResponse(r){
    return r;
}

function errorResponse(e){
    return e;
}

app.service('auth', ['$http', function ($http) {
    return {
        signout: function(){
            o.url = '/signout.php';
            return http(o, $http);
        }
    }
}]);

app.factory('report', ['$http', function ($http) {
    return {
        getReports: function () {
            o.url = baseUrl + 'reports.php';
            return http(o, $http);
        }
    }
}]);

app.factory('gist', ['$http', function($http){
    return {
        getGist: function(page){
            o.url = baseUrl + 'gist.php?hot_gists=true&pageHotGist=' + page;
            return http(o, $http);
        },
        gistView: function (id) {
            o.url = urlRoot + 'rest/requests/process.gist.views.php?id=' + id;
            return http(o, $http);
        },
        getGistById: function(id){
            o.url = baseUrl + 'gist.php?id=' + id;
            return http(o, $http);
        },
        getGistBycatId: function(cId, page){
            // page = typeof page == 'undefined' ? page : 1;
            o.url = baseUrl + 'gist.php?category_id=' + cId + '&pageCatId=' + page;
            return http(o, $http);
        },
        getRelatedGists: function(cId){
            o.url = baseUrl + 'gist.php?r_g=' + cId;
            return http(o, $http);
        },
        getAllGistsLike: function(title){
            o.url = baseUrl + 'gist.php?gist_with_title=' + title;
            return http(o, $http);
        },
        setHotGist: function (id) {
            o.url = baseUrl + 'gist.php?hot_gist_id=' + id;
            return http(o, $http);
        },
        unsetHotGist: function (id) {
            o.url = baseUrl + 'gist.php?unset_hot_gist_id=' + id;
            return http(o, $http);
        },
        setAsTrendGist: function (id) {
            o.url = baseUrl + 'gist.php?set_trending_gist_id=' + id;
            return http(o, $http);
        },
        unsetAsTrendGist: function (id) {
            o.url = baseUrl + 'gist.php?unset_trending_gist_id=' + id;
            return http(o, $http);
        },
        updateGist: function (id, articleData, article) {
            switch (article){
                case 'post':
                    o.url = baseUrl + 'post.php?updatePostData=true&pId=' + id + '&postData=' + encodeURIComponent(articleData);
                    break;
                case 'gist':
                    o.url = baseUrl + 'gist.php?updateGistData=true&gId=' + id + '&gistData=' + encodeURIComponent(articleData);
                    break;
            }
            return http(o, $http);
        }
    }
}]);

app.factory('users', ['$http', function($http){
    var a;
    //declare dependency on $http
    return {
        getAllWithName: function(name){
            o.url = baseUrl + 'getUser.php?user_with_name=' + name;
            return http(o, $http);
        },
        getUserBySess: function(){
            o.url = baseUrl + 'getUser.php?sess=true';
            return http(o, $http);
        },
        getUserById:function(id){
            o.url = baseUrl + 'getUser.php?id=' + id;
            //get users by their id
            return http(o, $http);
        },
        getUserByName:function(n){
            o.url = baseUrl + 'getUser.php?username=' + n;
            return http(o, $http);
        },
        updateProfileImg: function(formData){
            $http({
                url: baseUrl + 'update.profile.php',
                data: formData,
                method: 'POST'
            }).then(function(r){
                return r;
            },function(e){
                return e;
            });
        },
        updateProfile: function(d){
            return $http({
                url: '/update.profile.info.php',
                data: d,
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function(r){
                return r;
            },function(e){
                return e;
            });
        }
    }
}]);

app.factory('post', ['$http', function ($http) {
    return {
        getPostByGistId: function(id, page){
            o.url = baseUrl + 'post.php?gist_id=' + id + '&page=' + page;
            return http(o, $http);
        },
        loadMore: function(p, g){
            o.url = baseUrl + 'post.php?page=' + p + '&gistID=' + g;
            return http(o, $http);
        },
        starred: function(id){
            o.url = baseUrl + 'starred-post.php?user_id=' + id;
            return http(o, $http);
        },
        getAllPostsLike: function(string){
            o.url = baseUrl + 'post.php?post_with_string=' + string;
            return http(o, $http);
        }
    }
}]);

// app.factory('scrollEvent', function ($window, $rootScope) {
//     return {
//         handler: ()=>{
//             var scrollTop, winheight, docHeight, N_docHeight, diff;
//             scrollTop = $window.scrollTop();
//             winheight =  $window.height(); //696
//             docHeight =  $(document).height(); //7504
//             N_docHeight = docHeight - 300; //7204
//             diff = docHeight - winheight; //6808
//             if(scrollTop + winheight > N_docHeight){
//
//             }
//         },
//     }
// });

// app.factory('MyData', function($websocket) {
//     // Open a WebSocket connection
//     var dataStream = $websocket('ws://localhost' + baseUrl + 'websocket.php');
//
//     var collection = [];
//
//     dataStream.onMessage(function(message) {
//         collection.push(JSON.parse(message.data));
//     });
//
//     dataStream.onOpen = function (e) {
//         log('Connected: '+ e);
//     };
//
//     var methods = {
//         collection: collection,
//         get: function() {
//             dataStream.send(JSON.stringify({ action: 'get' }));
//         }
//     };
//     return methods;
// });

app.factory('follower', ['$http', function ($http) {
    return {
        // follow: (d)=>{
        //     o.url = baseUrl + 'follow.php';
        //     return $http(o).then((r)=>{
        //         return r;
        //     }, (e)=>{
        //         return e;
        //     });
        // },
        getFollowers: function(t){
            o.url = baseUrl + 'follow.php?followers=true&id=' + t;
            return http(o, $http);
        },
        getFollowing: function(t){
            o.url = baseUrl + 'follow.php?following=true&id=' + t;
            return http(o, $http);
        }
    }
}]);

app.factory('notify', ['$http', function ($http) {
    return {
        notify: function(){
            o.url = baseUrl + 'notification.php';
            return http(o, $http);
        },
        getNewNotification: function(){
            o.url = baseUrl + 'notification.php?get_new=true';
            return http(o, $http);
        },
        seen: function(){
            o.url = baseUrl + 'notification.php?update_unread=true';
            return http(o, $http);
        }
    }
}]);

app.factory('misc', ['$location', '$anchorScroll', '$http', function($location, $anchorScroll, $http){
    return {
        emoji: function () {
            o.url = urlRoot + 'emoji-og.json';
            return http(o, $http);
        },
        getTodaysBirthdays: function(page){
            o.url = baseUrl + 'getUser.php?birthday=true&page=' + page;
            return http(o, $http);
        },
        dateConvert: function(dateobj, format){
            var year = dateobj.getFullYear();
            var month= ("0" + (dateobj.getMonth()+1)).slice(-2);
            var date = ("0" + dateobj.getDate()).slice(-2);
            var hours = ("0" + dateobj.getHours()).slice(-2);
            var minutes = ("0" + dateobj.getMinutes()).slice(-2);
            var seconds = ("0" + dateobj.getSeconds()).slice(-2);
            var day = dateobj.getDay();
            var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
            var dates = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
            var converted_date = "";
    
            switch(format){
                case "YYYY-MM-DD":
                    converted_date = year + "-" + month + "-" + date;
                    break;
                case "YYYY-MMM-DD DDD":
                    converted_date = year + "-" + months[parseInt(month)-1] + "-" + date + " " + dates[parseInt(day)];
                    break;
                case "DDD, DD MMM YYYY":
                    converted_date =  dates[parseInt(day)] + ", " + date + " " +  months[parseInt(month)-1] + " " + year;
                    break

            }
    
            return converted_date;
        },
        f2Converter: function(valNum){
            valNum = parseFloat(valNum);
            return (valNum - 32) / 1.8;
        },
        f2KConverter: function(valNum){
            valNum = parseFloat(valNum);
            return ((valNum - 32) / 1.8) + 273.15;
        },
        c2fConverter: function(valNum){
            valNum = parseFloat(valNum);
            return (valNum * 1.8) + 32;
        },
        c2kConverter: function(valNum){
            valNum = parseFloat(valNum);
            return valNum + 273.15;
        },
        k2Converter: function(valNum){
            valNum = parseFloat(valNum);
            return valNum - 273.15;
        },
        k2fConverter: function(valNum){
            valNum = parseFloat(valNum);
            return ((valNum - 273.15) * 1.8) + 32;
        },
        scrollTo: function(id){
            $location.hash(id);
            $anchorScroll();
        },
        timeSince: function(date){
            var seconds = Math.floor((new Date() - new Date(date)) / 1000);
            var duration = getDuration(seconds);
            var suffix = (duration.interval > 1 || duration.interval === 0) ? 's' : '';
            return duration.interval + ' ' + duration.epoch + suffix;
        },

        // timeSince: function (date) {
        //     var seconds = Math.floor((new Date() - date) / 1000);
        //
        //     var interval = Math.floor(seconds / 31536000);
        //
        //     if (interval > 1) {
        //         return interval + " years";
        //     }
        //     interval = Math.floor(seconds / 2592000);
        //     if (interval > 1) {
        //         return interval + " months";
        //     }
        //     interval = Math.floor(seconds / 86400);
        //     if (interval > 1) {
        //         return interval + " days";
        //     }
        //     interval = Math.floor(seconds / 3600);
        //     if (interval > 1) {
        //         return interval + " hours";
        //     }
        //     interval = Math.floor(seconds / 60);
        //     if (interval > 1) {
        //         return interval + " minutes";
        //     }
        //     return Math.floor(seconds) + " seconds";
        // },

        time_ago: function (time) {
            switch (typeof time) {
                case 'number':
                    break;
                case 'string':
                    time = +new Date(time);
                    break;
                case 'object':
                    if (time.constructor === Date) time = time.getTime();
                    break;
                default:
                    time = +new Date();
            }
            var time_formats = [
                [60, 'seconds', 1], // 60
                [120, '1 minute ago', '1 minute from now'], // 60*2
                [3600, 'minutes', 60], // 60*60, 60
                [7200, '1 hour ago', '1 hour from now'], // 60*60*2
                [86400, 'hours', 3600], // 60*60*24, 60*60
                [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
                [604800, 'days', 86400], // 60*60*24*7, 60*60*24
                [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
                [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
                [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
                [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
                [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
                [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
                [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
                [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
            ];
            var seconds = (+new Date() - time) / 1000,
                token = 'ago',
                list_choice = 1;

            if (seconds == 0) {
                return 'Just now'
            }
            if (seconds < 0) {
                seconds = Math.abs(seconds);
                token = 'from now';
                list_choice = 2;
            }
            var i = 0,
                format;
            while (format = time_formats[i++])
                if (seconds < format[0]) {
                    if (typeof format[2] == 'string')
                        return format[list_choice];
                    else
                        return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
                }
            return time;
        },

        timeS: function (date) {
            if (typeof date !== 'object') {
                date = new Date(date);
            }

            var seconds = Math.floor((new Date() - date) / 1000);
            var intervalType;

            var interval = Math.floor(seconds / 31536000);
            if (interval >= 1) {
                intervalType = 'year';
            } else {
                interval = Math.floor(seconds / 2592000);
                if (interval >= 1) {
                    intervalType = 'month';
                } else {
                    interval = Math.floor(seconds / 86400);
                    if (interval >= 1) {
                        intervalType = 'day';
                    } else {
                        interval = Math.floor(seconds / 3600);
                        if (interval >= 1) {
                            intervalType = "hour";
                        } else {
                            interval = Math.floor(seconds / 60);
                            if (interval >= 1) {
                                intervalType = "minute";
                            } else {
                                interval = seconds;
                                intervalType = "second";
                            }
                        }
                    }
                }
            }

            if (interval > 1 || interval === 0) {
                intervalType += 's';
            }

            return interval + ' ' + intervalType;
        },

        timeSnc: function (date) {

            var seconds = Math.floor(((new Date().getTime()/1000) - date)),
                interval = Math.floor(seconds / 31536000);

            if (interval > 1) return interval + "y";

            interval = Math.floor(seconds / 2592000);
            if (interval > 1) return interval + "m";

            interval = Math.floor(seconds / 86400);
            if (interval >= 1) return interval + "d";

            interval = Math.floor(seconds / 3600);
            if (interval >= 1) return interval + "h";

            interval = Math.floor(seconds / 60);
            if (interval > 1) return interval + "m ";

            return Math.floor(seconds) + "s";
        },

        timeAgoSince: function (ts){
            var now = new Date();
            ts = new Date(ts*1000);
            var delta = now.getTime() - ts.getTime();

            delta = delta/1000; //us to s

            var ps, pm, ph, pd, min, hou, sec, days;

            if(delta<=59){
                ps = (delta>1) ? "s": "";
                return delta+" second"+ps
            }

            if(delta>=60 && delta<=3599){
                min = Math.floor(delta/60);
                sec = delta-(min*60);
                pm = (min>1) ? "s": "";
                ps = (sec>1) ? "s": "";
                return min+" minute"+pm+" "+sec+" second"+ps;
            }

            if(delta>=3600 && delta<=86399){
                hou = Math.floor(delta/3600);
                min = Math.floor((delta-(hou*3600))/60);
                ph = (hou>1) ? "s": "";
                pm = (min>1) ? "s": "";
                return hou+" hour"+ph+" "+min+" minute"+pm;
            }

            if(delta>=86400){
                days = Math.floor(delta/86400);
                hou =  Math.floor((delta-(days*86400))/60/60);
                pd = (days>1) ? "s": "";
                ph = (hou>1) ? "s": "";
                return days+" day"+pd+" "+hou+" hour"+ph;
            }

        }
    // var aDay = 24 * 60 * 60 * 1000;
    // console.log(timeSince(new Date(Date.now() - aDay)));
    // console.log(timeSince(new Date(Date.now() - aDay * 2)));

        // var aDay = 24 * 60 * 60 * 1000;
        // console.log(time_ago(new Date(Date.now() - aDay)));
        // console.log(time_ago(new Date(Date.now() - aDay * 2)));
    }
}]);