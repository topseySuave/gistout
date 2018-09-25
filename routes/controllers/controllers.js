/**
 * Created by Daniel on 7/3/2017.
 */
/*
 *  GistOut App controllers
 * */

/** files to upload:
 * Add Clicks column to gist_ads table.
 * */

// Instagram story link demo codepen...:::: https://codepen.io/lokesh/pen/KrLKOE

// app = angular.module("demo", []);
//
// app.controller("MainController", function($scope, $http){
//
//     // the array which represents the list
//     $scope.items = ["1. Scroll the list to load more"];
//     $scope.loading = true;
//
//     // this function fetches a random text and adds it to array
//     $scope.more = function(){
//         $http({
//             method: "GET",
//             url: "https://baconipsum.com/api/?type=all-meat&paras=2&start-with-lorem=1"
//         }).success(function(data, status, header, config){
//
//             // returned data contains an array of 2 sentences
//             for(var line in data){
//                 var newItem = ($scope.items.length+1)+". "+data[line];
//                 $scope.items.push(newItem);
//             }
//             $scope.loading = false;
//         });
//     };
//
//     // we call the function twice to populate the list
//     $scope.more();
// });
//
// // we create a simple directive to modify behavior of <ul>
// app.directive("whenScrolled", function(){
//     return{
//
//         restrict: 'A',
//         link: function(scope, elem, attrs){
//
//             // we get a list of elements of size 1 and need the first element
//             var raw = elem[0];
//
//             // we load more elements when scrolled past a limit
//             elem.bind("scroll", function(){
//                 if(raw.scrollTop+raw.offsetHeight+5 >= raw.scrollHeight){
//                     scope.loading = true;
//
//                     // we can give any function which loads more elements into the list
//                     scope.$apply(attrs.whenScrolled);
//                 }
//             });
//         }
//     }
// });

'use strict';

const urlRoot = '/';
const baseUrl = urlRoot + 'api/';
const baseTitle = 'Gistout - Discuss';
const baseKeywords = 'Forum, discussion, chat, live, Nairaland, gist, article, discuss, gossip, story, blog, news, entertainment, politics, fashion';
const baseDescription = 'gistout.com an international discussion forum made to entertain and make discussion fun';
const openWeatherApiId = 'ff2c7dbb6d154c539de8bb55e9bdbe14';
const fb_app_id = '322819981522430';
const loaderImg2 = '<img src="'+ urlRoot +'docs/img/loaders/default2.gif" style="width: 20px; height: 20px;margin: 8px;">';
var blop = "/docs/audio/Blop.mp3";
var audio = new Audio(blop);

app.controller('rprtCntrllr', ['$filter', '$scope', '$rootScope', 'report', function ($filter, $scope, $rootScope, report) {
    $rootScope.pageTitle = 'Report - DashBoard | ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')(baseTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = baseDescription + ' - ' + $rootScope.pageTitle;
    $rootScope.pageLocation = location.href;
    $scope.isLoaded = false;
    var rep = report.getReports();
    rep.then(function (r) {
        if(r.data.report.length > 0){
            log(r.data);
            $scope.isLoaded = true;
            $scope.noData = false;
            $scope.reports = r.data.report;
        }else{
            $scope.isLoaded = false;
            $scope.noData = true;
        }
    }, function (e) {
        log(e);
        Materialize.toast('Error in Connection', 5000);
    });
}]);

app.controller('brthdyCntrllr', ['$scope', 'misc' , function ($scope, misc){
    var page = 1;
    var bd = misc.getTodaysBirthdays(page);
    bd.then(function(r){
        if(r.data.users.length > 0){
            $scope.noBirthday = false;
            $scope.birthday = r.data.users;
        }else{
            $scope.noBirthday = true;
        }
    },function(e){log(e)});
}]);

app.controller('sgnoutCntrllr', ['$location', 'auth', function ($location, auth) {
    var out = auth.signout();
    out.then(function(r){
        if (r.data) {
            var redir = $location.search();
            location.href = redir.redirect;
        }
    }, function(e){
        log(e);
    });
}]);

app.controller("mnCntrllr", ['$anchorScroll', '$filter', '$scope', '$http', '$sce', '$route',
    'users', 'gist', 'misc', 'notify', '$rootScope', '$location',
    function ($anchorScroll, $filter, $scope, $http, $sce, $route, users, gist,
              misc, notify, $rootScope, $location) {
                var u, i, g, h, a, d, seen, id, gistArticle;
                $rootScope.pageTitle = baseTitle;
                $rootScope.pageKeywords = $filter('keywordise')(baseTitle) + ', ' + baseKeywords;
                $rootScope.pageDescription = baseDescription + ' - ' + $rootScope.pageTitle;
                $rootScope.pageLocation = location.href;
                $rootScope.cacheBustParam = '?v=2.0.1';
                $rootScope.gistoutDomain = 'https://gistout.com/';
                $rootScope.imgOptim = function (option, cropSize) {
                    cropSize = typeof cropSize !== 'undefined' ? cropSize + 'x' + cropSize: '200x200';
                    switch(option){
                        case 'fit':
                            return 'https://img.gs/znvfwgxszs/fit/';
                            break;
                        case 'crop':
                            return 'https://img.gs/znvfwgxszs/' + cropSize + ',crop=auto/';
                            break;
                    }
                };
                $scope.busy = true;
                $scope.noMoreGists = true;
                var page = 1;
                var read = null;

                if($location.hash()) $anchorScroll();

                // setInterval(function(){
                //     log(navigator.onLine);
                // }, 5000);

                $scope.scrollTo = function(id) {
                    // set the location.hash to the id of
                    // the element you wish to scroll to.
                    $location.hash(id);
                    // call $anchorScroll()
                    $anchorScroll();
                };

                $(window).on('load', function () {
                    init();
                    // $('body').append('<script type="text/javascript" src="lib/js/emoji.min.js"></script><script type="text/javascript" src="lib/js/wdt-emoji-bundle.min.js"></script>');
                    // $('._2loadingcover').fadeOut();
                    wdtEmojiBundle.defaults.emojiType = 'twitter';
                    wdtEmojiBundle.defaults.pickerColors = ['green1', 'pink1', 'yellow1', 'blue1', 'gray1'];
                    wdtEmojiBundle.init('#postArea');
                    // if(isOnline($http)){
                    //     Materialize.toast('Successful connection!!', 5000);
                    // }else{
                    //     Materialize.toast('Error in connection!!', 5000);
                    // }
                    // log(isOnline($http));
                });

                $scope.goSearch = function(searchString){
                    $location.path('search/').search({ q: encodeURIComponent(searchString) });
                };
                // weatherApi();
                // function weatherApi() {
                //     $scope.weatherReady = false;
                //     // var weatherObj = {"coord":{"lon":3.4,"lat":6.45},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],"base":"stations","main":{"temp":297.858,"pressure":1023.93,"humidity":96,"temp_min":297.858,"temp_max":297.858,"sea_level":1028.83,"grnd_level":1023.93},"wind":{"speed":3.88,"deg":233.004},"rain":{"3h":0.115},"clouds":{"all":88},"dt":1500508033,"sys":{"message":0.0146,"country":"NG","sunrise":1500442766,"sunset":1500487565},"id":2332459,"name":"Lagos","cod":200}
                //     var country, countryCode;
                //     var onSuccess = function(location){
                //         country = location.country.names.en;
                //         $scope.weatherStateName = location.city.names.en;
                //         $scope.weatherCntCode = country;
                //         countryCode = location.country.iso_code;
                //         o.url = 'http://api.openweathermap.org/data/2.5/weather?q='+country+','+countryCode+'&appid='+openWeatherApiId;
                //         $http(o).then(function(r){
                //             $scope.weatherIcon = r.data.weather[0].icon;
                //             $scope.weatherMain = r.data.weather[0].main;
                //             $scope.weatherTemp = Math.round(misc.k2Converter(r.data.main.temp));
                //             $scope.weatherReady = true;
                //         },function(e){
                //             log(e);
                //         });
                //     };
                //     var onError = function(error){
                //         log(error);
                //     };
                //     geoip2.city(onSuccess, onError);
                // }

                $scope.dateTime = misc.dateConvert(new Date(), "DDD, DD MMM YYYY");

                var played = false;
                $rootScope.$on("$routeChangeSuccess", function () {
                    window.scrollTo(0, 0);
                    a = notify.getNewNotification();
                    a.then(function(r){
                        if(r.data > 0){
                            $scope.hasNoti = true;
                            $scope.notificationCount = r.data;
                            read = true;
                            if(played){
                                return
                            }else {
                                audio.play();
                                played = true;
                            }
                            $rootScope.pageTitle = '('+ $scope.notificationCount +') ' + baseTitle;
                        }else{
                            $scope.hasNoti = false;
                            read = false;
                        }
                    },function(e){
                        Materialize.toast('Error in Connection!', 5000);
                        log(e);
                    });
                });

                $scope.btnText = $sce.trustAsHtml('post');
                $scope.addPost = function(){
                    // alert('hello world');
                    var $this = $('#add_post');
                    var quote_content = $('.Editor-editor').html();
                    quote_content = wdtEmojiBundle.render(quote_content);
                    // var postID = $('.Editor-editor').data('post-id');
                    var postCount = parseInt($('#posts-count').html());
                    var gCountPost = parseInt($('#g-count-post').html());
                    var EditorContainer = $('.Editor-container');
                    var quoteHolder = $('#qoute-holder');
                    var file_data = $("#imgContent").prop("files")[0]; // Getting the properties of file from file field
                    var data = new FormData(); // Creating object of FormData class
                    data.append("file", file_data); // Appending parameter named file with properties of file_field to form_data
                    if (quote_content === '') {
                        var animate = 'animated shake';
                        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd animationEnd';
                        EditorContainer.addClass(animate).one(animationEnd, function () {
                            EditorContainer.removeClass(animate);
                        });
                        $this.html('Post');
                        $this.removeAttr('disabled');
                    }
                    else {
                        var datRole = EditorContainer.data('role');
                        if (datRole === 'post') {
                            $scope.btnText = $sce.trustAsHtml(loaderImg2);
                            $this.attr('disabled');
                            var sess = EditorContainer.data('sess');
                            var gistID = EditorContainer.data('gist-id');
                            var gistUserID = EditorContainer.data('gist-user-id');
                            data.append('quoteContent', quote_content);
                            data.append('gist_user_id', gistUserID);
                            data.append('gist_id', gistID);
                            data.append('sess', sess);
                            $.ajax({
                                url: '/create-post.php',
                                type: 'POST',
                                data: data,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (x) {
                                    // log(x);
                                    if (x == 0) {
                                        Materialize.toast('Error Posting');
                                        $scope.btnText = $sce.trustAsHtml('post');
                                        $this.removeAttr('disabled');
                                    } else if (x == 2) {
                                        Materialize.toast('Error Posting.. Already Exist');
                                        $scope.btnText = $sce.trustAsHtml('post');
                                        $this.removeAttr('disabled');
                                    } else {
                                        var p = JSON.parse(x);
                                        p = p.posts[0];
                                        p.content = $sce.trustAsHtml(p.content);
                                        p.quoteContent = $sce.trustAsHtml(p.quoteContent);
                                        $scope.$broadcast('newPostData', p);
                                        $('#posts-count').html(postCount + 1);
                                        $('#g-count-post').html(gCountPost + 1);
                                        $scope.btnText = $sce.trustAsHtml('post');
                                        $this.removeAttr('disabled');
                                        $('.Editor-editor').html('');
                                        // $('#contentData').reset();
                                        $('#box-pop').css({'transform': 'translateY(1000px)'});
                                        $('.fixed-action-btn').removeClass('bounceOutDown');
                                        window.scrollTo(0, document.body.scrollHeight);
                                        // $route.reload();
                                        // file_data = '';
                                        resetFileElement($("#imgContent"));
                                    }
                                }
                            });
                        }
                        else if (datRole === 'quote') {
                            $scope.btnText = $sce.trustAsHtml(loaderImg2);
                            $this.attr('disabled');
                            var id = EditorContainer.data('purpose');
                            var postUserId = EditorContainer.data('purposeful');
                            var sess = EditorContainer.data('sess');
                            var gistID = EditorContainer.data('gist-id');
                            data.append('quoteContent', quote_content);
                            data.append('gist_id', gistID);
                            data.append('postID', id);
                            data.append('postUserId', postUserId);
                            data.append('sess', sess);

                            $.ajax({
                                url: '/create-quote.php',
                                type: 'POST',
                                data: data,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (x) {
                                    // log(x);
                                    if (x == 0 || x == 2) {
                                        Materialize.toast('Error Posting');
                                        $scope.btnText = $sce.trustAsHtml('post');
                                        $this.removeAttr('disabled');
                                    }
                                    else {
                                        var p = JSON.parse(x);
                                        p = p.posts[0];
                                        p.content = $sce.trustAsHtml(p.content);
                                        p.quoteContent = $sce.trustAsHtml(p.quoteContent);
                                        $scope.$broadcast('newPostData', p);
                                        $('#posts-count').html(postCount + 1);
                                        $('#g-count-post').html(gCountPost + 1);
                                        $('.Editor-editor').html('');
                                        // $('.modal-close').click();
                                        $scope.btnText = $sce.trustAsHtml('post');
                                        $this.removeAttr('disabled');
                                        $('#box-pop').css({'transform': 'translateY(1000px)'});
                                        $('.fixed-action-btn').removeClass('bounceOutDown');
                                        window.scrollTo(0, document.body.scrollHeight);
                                        // $route.reload();
                                        // file_data = '';
                                        resetFileElement($("#imgContent"));
                                    }
                                }
                            });
                        }
                        else if (datRole === 'gist') {
                            // alert(datRole);
                            $scope.btnText = $sce.trustAsHtml(loaderImg2);
                            $this.attr('disabled');
                            var title = $('#gistTitle').val();
                            var sess = EditorContainer.data('sess');
                            var catID = EditorContainer.data('cat-id');
                            data.append('quoteContent', quote_content);
                            data.append('title', title);
                            data.append('cat_id', catID);
                            data.append('sess', sess);
                            if (title == '' || title < 1) {
                                var animate = 'animated shake';
                                var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationEnd animationEnd';
                                $('#gist-title-input').addClass(animate).one(animationEnd, function () {
                                    $('#gist-title-input').removeClass(animate);
                                });
                            } else {
                                $.ajax({
                                    url: '/create-gist.php',
                                    type: 'POST',
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function (x) {
                                        // log(x);
                                        if (x == 0) {
                                            Materialize.toast('Error Adding Gist', 4000);
                                            $scope.btnText = $sce.trustAsHtml('post');
                                            $this.removeAttr('disabled');
                                        }
                                        else if (x == 2) {
                                            Materialize.toast('Error Gisting.. Already Exist', 4000);
                                            $scope.btnText = $sce.trustAsHtml('post');
                                            $this.removeAttr('disabled');
                                        }
                                        else
                                        {
                                            $('.Editor-editor').html('');
                                            $('#gistTitle').val('');
                                            $scope.btnText = $sce.trustAsHtml('post');
                                            $this.removeAttr('disabled');
                                            $route.reload();
                                            $('#box-pop').css({'transform': 'translateY(1000px)'});
                                            $('.fixed-action-btn').removeClass('bounceOutDown');
                                            // file_data = '';
                                            resetFileElement($("#imgContent"));
                                        }
                                    }
                                });
                            }
                        }
                    }
                };

                u = users.getUserBySess();
                u.then(function(r){
                    if (r.data) {
                        for (i = 0; i < r.data.users.length; i++) {
                            $rootScope.unique_id = r.data.users[i].unique_id;
                            $rootScope.fullname = r.data.users[i].fullname;
                            $rootScope.profile_img = r.data.users[i].user_avatar;
                            $rootScope.username = r.data.users[i].username;
                            $rootScope.id = r.data.users[i].id;
                            (r.data.users[i].status === 'super_user')? $rootScope.superUser = true: $rootScope.superUser = false;
                            // Materialize.toast(r.data.users[i].status);
                        }
                        $rootScope.isLoggedIn = true;
                        $rootScope.$broadcast('is:logged:in', true);
                    } else {
                        $rootScope.isLoggedIn = false;
                    }
                }, function(e){
                    log(e)
                });

                o.url = baseUrl + 'right-side.php';
                $http(o).then(function(r){
                    d = r.data;
                    // Ads
                    if(d.ad.length !== 0){
                        if (d.ad.gist_ads.length > 0) {
                            $scope.noAd = false;
                            $scope.ad = d.ad.gist_ads[0];
                        } else {
                            $scope.noAd = true;
                        }
                    } else {
                        $scope.noAd = true;
                    }

                    //Top categories
                    $scope.cat = d.c.category;

                    // Trending Hashtag
                    if(d.th.length !== 0){
                        if (d.th.trending_hashtag.length > 0) {
                            $scope.noTh = false;
                            $scope.th = d.th.trending_hashtag;
                        } else {
                            $scope.noTh = true;
                        }
                    } else {
                        $scope.noTh = true;
                    }

                    // Top Users
                    if(d.tu.length !== 0){
                        if (d.tu.users.length > 0) {
                            $scope.noTu = false;
                            $scope.tu = d.tu.users;
                        } else {
                            $scope.noTu = true;
                        }
                    } else {
                        $scope.noTu = true;
                    }

                    //todays birthdays
                    if(d.dob.length !== 0){
                        if (d.dob.users.length > 0) {
                            $scope.noDob = false;
                            $scope.dob = d.dob.users;
                        } else {
                            $scope.noDob = true;
                        }
                    } else {
                        $scope.noDob = true;
                    }
                }, function(e){
                    /**
                     * Error in connection page
                     **/
                    log(e)
                });

                $rootScope.$watch('pageLocation', function(newVal, oldVal){
                    var str = /\/gist\//gi;
                    var urlVal = newVal.toString().lastIndexOf('/sign');
                    (urlVal > -1) ? $scope.isLogInPage = true: $scope.isLogInPage = false;

                    var bDayUrl = newVal.toString().lastIndexOf('/birthday');
                    (bDayUrl > -1)? $scope.isBDayPage = true: $scope.isBDayPage = false;

                    var uri = newVal.toString().match(str);
                    if (uri !== null) {
                        ang.forEach(uri, function(p){
                            if(p === '/gist/'){
                                $scope.noRg = false
                            }else{
                                $scope.noRg = true;
                            }
                        });
                    } else {
                        $scope.noRg = true;
                    }
                    $scope.redirectAfterAuth = encodifyURI(newVal);

                    var notifyUrl = newVal.toString().lastIndexOf('/notification');
                    if(read){
                        if(notifyUrl > -1){
                            $scope.hasNoti = false;
                            $rootScope.pageTitle = baseTitle;
                            seen = notify.seen();
                            seen.then(function(r){var sn = r.data ? r.data : !r.data;},function(e){log(e)});
                            played = false;
                        }
                    }
                });

                $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
                    init();
                });

                $scope.editGist = function (id, articleId) {
                    $('#editGist').modal('open');
                    var gistArticle = $('#gistArticle-' + id).html();
                    var editText = $('#editText');
                    editText.html(gistArticle);
                    if(articleId === 'post'){
                        editText.attr('data-post-id', id);
                    }else if(articleId === 'gist'){
                        editText.attr('data-gist-id', id);
                    }
                    editText.attr('data-article', articleId);
                };

                $scope.updateGist = function () {
                    var editText = $('#editText');
                    var newData = editText.html();
                    var article = editText.attr('data-article');
                    if(article === 'post'){
                        id = editText.attr('data-post-id');
                        gistArticle = $('#gistArticle-' + id);
                    }else if(article === 'gist'){
                        id = editText.attr('data-gist-id');
                        gistArticle = $('#gistArticle-' + id);
                    }
                    gistArticle.html(newData);
                    gistArticle.css({'opacity': '.4'});
                    $scope.emptyEditor();
                    $('#editGist').modal('close');
                    // log(newData);
                    var updateGist = gist.updateGist(id, newData, article);
                    updateGist.then(function (r) {
                        (r.data == 1)? gistArticle.css({'opacity': '1'}): Materialize.toast('Error please try again', 5000);
                    }, function (e) {
                        log(e);
                    });
                };

                $scope.emptyEditor = function () {
        var editText = $('#editText');
        editText.html('');
    }
}]);

app.controller("hotGistsController", ['$filter', '$scope', '$http', '$route', 'gist',
    '$rootScope', function ($filter, $scope, $http, $route, gist, $rootScope) {
    var u, i, g, h, a, d;
    $rootScope.pageTitle = baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')(baseTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle;
    $rootScope.pageLocation = location.href;
    $scope.busy = true;
    $scope.noMoreGists = true;
    var page = 1;

    g = gist.getGist(page);
    g.then(function(r){
        if (r.data.gists.length > 0) {
            $scope.noHotGist = false;
            $scope.gists = r.data.gists; // gist object
            page += 1;
            (r.data.gists.length < 20) ? $scope.noMoreGists = true : $scope.noMoreGists = false;
            $scope.busy = false;
        }else{
            $scope.noHotGist = true;
            $scope.noMoreGists = false;
        }
    }, function(e){
        /**
         * Error in connection page
         **/
        log(e);
        Materialize.toast('Error in connection!', 5000);
    });

    $scope.loadMoreHotGists = function(){
        if ($scope.busy) return;
        $scope.busy = true;
        $scope.noMoreGists = true;
        h = gist.getGist(page);
        h.then(function(r){
            log(r.data);
            if(r.data.gists.length > 0){
                for(i = 0; i < r.data.gists.length; i++){
                    $scope.gists.push(r.data.gists[i]);
                }
                $scope.busy = false;
                $scope.noMoreGists = false;
            }else{
                $scope.busy = false;
                $scope.noMoreGists = true;
            }
        },function(e){
            log(e);
            Materialize.toast('Error in connection!', 5000);
        });
    };
}]);

app.controller("prflCntrllr", ['$filter', '$scope', '$routeParams', '$route',
    '$http', '$sce', '$rootScope', 'Upload', 'users',
    function ($filter, $scope, $routeParams, $route, $http, $sce, $rootScope, Upload, users) {
    $rootScope.pageTitle = $routeParams.username + ' - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')(baseTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.isLoaded = false;
    var saveProfileBtn = $('#saveProfile');
    /**
     * Use $http to get user by username here as defined in the parameter
     **/
    o.url = baseUrl + 'getUser.php?username=' + $routeParams.username;
    $http(o).then(function(res){
        if (res !== '') {
            var i;
            for (i = 0; i < res.data.users.length; i++) {
                res.data.users[i].bio = $sce.trustAsHtml(res.data.users[i].bio);
                $scope.u = res.data.users[i];
                $scope.isLoaded = true;
                var strCount = res.data.users[i].starProgress.stars_count;
                $scope.star = starCount(strCount);
            }
        } else {
            location.path = urlRoot + '404';
        }
    }, function(err){
        /**
         * Error in connection page
         **/
        log(err);
    });

    $scope.$on('$viewContentLoaded', function(){
        //Here your view content is fully loaded !!
        init();
    });

    // upload later on form submit or something similar
    $scope.updateProfileImg = function () {
        if ($scope.form.file.$valid && $scope.file) {
            $scope.upload($scope.file);
        }
    };

    // upload on file select or drop
    $scope.upload = function (file) {
        Upload.upload({
            url: '/update.profile.php',
            data: { file: file },
            headers: { 'Content-Type': 'application/json' } //Content-Type: application/json; charset=utf-8
        }).then(function (resp) {
            if (resp.data === 5) {
                location.reload();
            } else if (resp.data === 3) {
                Materialize.toast('File type not supported or is to large', 5000);
            } else if (resp.data === 2) {
                Materialize.toast('Failed to upload', 5000);
            } else if (resp.data === 0) {
                Materialize.toast('Invalid Request', 5000);
            }
            // log('Success ' + resp.config.data.file.name + ': uploaded. Response: ' + resp.data);
        }, function (resp) {
            log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
    };

    $scope.submitProfileUpdate = function(){
        // alert('hello world');
        saveProfileBtn.html(loaderImg2);
        var inputBio = $('#inputBio').val();
        var InputFullName = $('#InputFullName').val();
        var InputEmail = $('#InputEmail').val();
        var InputNickname = $('#InputNickname').val();
        var Dob = $('#Dob').val();
        var InputWebsite = $('#InputWebsite').val();
        var InputPassword = $('#InputPassword').val();
        // var data = 'inputBio='+inputBio+'&InputFullName='+InputFullName+'&InputEmail='+InputEmail+'&InputNickname='+InputNickname+'&Dob='+Dob+'&InputWebsite='+InputWebsite+'&InputPassword='+InputPassword;
        var data = { 'inputBio': inputBio, 'InputFullName': InputFullName, 'InputEmail': InputEmail, 'InputNickname': InputNickname, 'Dob': Dob, 'InputWebsite': InputWebsite, 'InputPassword': InputPassword };
        // log(data);
        var result = users.updateProfile(data);
        result.then(function(r){
            saveProfileBtn.html('save profile');
            (r.statusText == 'OK') ? $route.reload() : Materialize.toast('<b>GO BUTLER : </b>Oops!! the request you are trying to make is invalid.', 5000);
        }, function(e){
            log(e);
        });
    }
}]);

app.controller('ctgryLstCntrllr', ['$filter', '$scope', '$http', '$rootScope',
    function ($filter, $scope, $http, $rootScope) {
    $rootScope.pageTitle = 'Categories - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')(baseTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.busy = true;
    o.url = baseUrl + 'category.php';
    $http(o).then(function(res){
        if (res !== "") {
            var i, c;
            for (i = 0; i < res.data.category.length; i++) {
                $scope.c = res.data.category;
            }
            $scope.busy = true;
        } else {
            Materialize.toast('No category found', 5000, 'rounded', function () {
                location.href = '/404';
            });
            $scope.busy = false;
        }
    }, function(err){
        /**
         * Error in connection page
         **/
        log(err);
    });
    $scope.$on('ngRepeatFinished', function(){
        init();
    });
}]);

app.controller('ctgryGstCntrllr', ['$filter', '$scope', '$rootScope', '$routeParams',
    'misc', '$http', 'users', 'gist', function ($filter, $scope, $rootScope, $routeParams, misc, $http, users, gist) {
    $scope.$on('ngRepeatFinished', function () {
        init();
    });
    $scope.busy = true;
    o.url = baseUrl + 'category.php?title=' + $routeParams.category;
    $http(o).then(function(res){
        if (res.data.category[0] !== undefined) {
            var a, i, cl, g, u;
            var h = [];
            cl = res.data.category; // Array of Objects
            $scope.cl = cl[0]; // Objects
            $rootScope.pageKeywords = $filter('keywordise')(baseTitle) + ', ' + baseKeywords;
            $rootScope.pageTitle = $scope.cl.title + ' - ' + baseTitle;
            $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
            $rootScope.pageLocation = location.href;
            $scope.timago = misc.timeSince;
            // $scope.noGist = false;
            // $scope.noHotGist = false;
            // $scope.noTrendingGist = false;
            // $scope.noLastUpGist = false;
            o.url = baseUrl + 'category.php?process_cat_views=true&viewsCat=' + $scope.cl.id;
            http(o, $http).then(function (r) {
                if(!r.data){
                    log(r.data);
                }
            }, function (e) {
                log(e);
            });
            var page = 1;
            g = gist.getGistBycatId($scope.cl.id, page);
            g.then(function(r){
                /**
                 * All gists
                 * **/
                if(r.data.allGist.gists.length > 0){
                    $scope.noGist = false;
                    $scope.ag = r.data.allGist.gists; // Array of Objects
                }else{
                    $scope.noGist = true;
                }

                /**
                 * hot gists
                 * **/
                if(r.data.hotGists.gists.length > 0){
                    $scope.noHotGist = false;
                    $scope.hg = r.data.hotGists.gists; // Array of Objects
                }else{
                    $scope.noHotGist = true;
                }

                /**
                 * trending gists
                 * **/
                if(r.data.trendingGists.gists.length > 0){
                    $scope.noTrendingGist = false;
                    $scope.tg = r.data.trendingGists.gists; // Array of Objects
                }else{
                    $scope.noTrendingGist = true;
                }

                /**
                 * last updated gists
                 * **/
                if(r.data.lastUpdatedGists.gists.length > 0) {
                    $scope.noLastUpGist = false;
                    $scope.lug = r.data.lastUpdatedGists.gists; // Array of Objects
                }else{
                    $scope.noLastUpGist = true;
                }
                if((r.data.allGist.gists.length > 0) || (r.data.hotGists.gists.length > 0) || (r.data.trendingGists.gists.length > 0) || (r.data.lastUpdatedGists.gists.length > 0)){
                    // log(r.data.allGist.gists.length);
                    $scope.emptyCat = false;
                }else{
                    $scope.emptyCat = true;
                }
                $scope.busy = false;
            },function(err){
                Materialize.toast('Error in Connection!', 5000);
                log(err);
            });
        } else {
            location.href = urlRoot + '404';
        }
    }, function(err){
        /**
         * Error in connection page
         **/
        Materialize.toast('Error in Connection!', 5000);
        log(err);
    });
}]);

app.controller('gstCntrllr', ['$scope', '$rootScope', '$routeParams',
    '$sce', '$http', '$injector', 'gist', 'users', 'post', '$filter',
    function ($scope, $rootScope, $routeParams, $sce, $http, $injector, gist, users, post, $filter) {
    var d, u, p, i, l, g, a, gistView, set, unset, setTrend, unSetTrend;
    var lastPost, gistId;
    $scope.busy = false;
    $scope.noMorePosts = true;
    var title = $filter('undoPermalink')($routeParams.gist);
    $rootScope.pageTitle = title + ' - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')(baseTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.isLoaded = false;
    $scope.isLoadingMore = false;
    $scope.pData = [];
    var page = 1;
    g = gist.getGistById($routeParams.id);
    g.then(function(r){
        if (r.data.gists[0] !== undefined) {
            d = r.data.gists[0];
            (d.hasImage) ? $scope.pageImage = d.image: $scope.pageImage = d.image;
            d.content = $sce.trustAsHtml(d.content);
            var urlArr = location.href.split('#');
            d.location = encodeURIComponent(urlArr[0]);
            $scope.gistData = d; // Gist's Array of object
            $scope.$broadcast('contentLoaded');
            $rootScope.superUser || d.isAdmin ? $rootScope.authGistEdit = true: $rootScope.authGistEdit = false;
            if (d.hasPosts) {
                p = post.getPostByGistId(d.id, page);
                p.then(function(r){
                    for (i = 0; i < r.data.posts.length; i++) {
                        r.data.posts[i].content = $sce.trustAsHtml(r.data.posts[i].content);
                        r.data.posts[i].quoteContent = $sce.trustAsHtml(r.data.posts[i].quoteContent);
                        $rootScope.isAdmin = r.data.posts[i].isAdmin;
                        $rootScope.superUser || $rootScope.isAdmin ? $rootScope.authPostEdit = true: $rootScope.authPostEdit = false;
                        $scope.pData.push(r.data.posts[i]); //Post's Array of objects
                    }
                    $scope.isLoaded = true;
                    $scope.noData = false;
                    r.data.posts.length < 20? $scope.noMorePosts = true: $scope.noMorePosts = false;
                    page += 1;
                }, function(e){
                    Materialize.toast('Error in connection', 5000);
                });
            } else {
                $scope.isLoaded = true;
                $scope.noData = true;
            }
            l = gist.getRelatedGists(d.category_id);
            l.then(function(res){
                var h = res.data.gists;
                if(h){
                    for (a = 0; a < h.length; a++) {
                        (h[a].id == $routeParams.id) ? h.splice(a, 1) : $scope.relatedGists = h;
                    }
                    var r = $scope.$parent.$parent.relatedGists = $scope.relatedGists;
                    (r.length > 0) ? $scope.noRg = false : $scope.noRg = true;
                }
            }, function(er){
                Materialize.toast('Error in connection', 5000);
            });
        } else {
            location.href = urlRoot + '404';
        }
    }, function (e) {
        /**
         * Error in connection page
         **/
        Materialize.toast('Error in Connection!', 5000);
        log(e);
    });

    gistView = gist.gistView($routeParams.id);
    gistView.then(function (r) {
       // var views = parseInt($('#viewsG').text() + 1);
       // $('#viewsG').text(views);
    }, function (e) {log(e);});

    $scope.$on('newPostData', function(event, data){
        $scope.$apply(function(){
            $scope.pData.push(data);
            $scope.noData = false;
        });
    });
    $scope.loadMore = function(){
        if ($scope.busy) return;
        $scope.busy = true;
        $scope.noMorePosts = true;
        gistId = $('#lastPost').attr('data-gistLast');
        // log('page=' + page + ', gist_id=' + gistId);
        var lm = post.getPostByGistId(gistId, page);
        lm.then(function(r){
            if (r.data.posts.length > 0) {
                for (i = 0; i < r.data.posts.length; i++) {
                    r.data.posts[i].content = $sce.trustAsHtml(r.data.posts[i].content);
                    r.data.posts[i].quoteContent = $sce.trustAsHtml(r.data.posts[i].quoteContent);
                    $scope.pData.push(r.data.posts[i]);
                }
                $scope.busy = false;
                $scope.noMorePosts = false;
                page += 1;
            } else {
                $('#loadmoreBtn').remove();
                $scope.busy = false;
                $scope.noMorePosts = true;
            }
        }, function(e){
            log(e);
        });
    };

    $scope.$on('ngRepeatFinished', function () {
        init();
    });

    $scope.addAsHotFlag = function(id){
        var hotid = $('#hotFlag');
        hotid.removeClass('grey-text');
        hotid.addClass('red-text');

        set = gist.setHotGist(id);
        set.then(function (r) {
            log(r.data);
            if(r.data){
                $scope.gistData.hot_flag = 1;
                hotid.attr('ng-click', 'unSetHot(gistData.id)');
                hotid.attr('data-tooltip', 'unset as hot gist');
            }else{
                hotid.removeClass('red-text');
                hotid.addClass('grey-text');
            }
        }, function (e) {
            Materialize.toast('Error in Connection', 5000);
        });
    };

    $scope.unSetHot = function (id) {
        var hotid = $('#hotFlag');
        hotid.removeClass('red-text');
        hotid.addClass('grey-text');

        unset = gist.unsetHotGist(id);
        unset.then(function (r) {
            log(r.data);
            if(r.data){
                $scope.gistData.hot_flag = 0;
                hotid.attr('ng-click', 'addAsHotFlag(gistData.id)');
                hotid.attr('data-tooltip', 'set as hot gist');
            }else{
                hotid.removeClass('red-text');
                hotid.addClass('grey-text');
            }
        }, function (e) {
            Materialize.toast('Error in Connection', 5000);
        });
    };

    $scope.addAsTrending = function(id){
        var trendId = $('#trending');

        trendId.removeClass('grey-text');
        trendId.addClass('teal-text');

        setTrend = gist.setAsTrendGist(id);
        setTrend.then(function (r) {
            if(r.data){
                trendId.attr('ng-click', 'removeAsTrending(gistData.id)');
                trendId.attr('data-tooltip', 'unset as trending');
            }
        }, function (e) {
            Materialize.toast('Error in Connection', 5000);
            log(e);
        });
    };

    $scope.removeAsTrending = function(id){
        var trendId = $('#trending');

        trendId.removeClass('teal-text');
        trendId.addClass('grey-text');

        unSetTrend = gist.unsetAsTrendGist(id);
        unSetTrend.then(function (r) {
            if(r.data){
                trendId.attr('ng-click', 'addAsTrending(gistData.id)');
                trendId.attr('data-tooltip', 'set as trending');
            }
        }, function (e) {
            Materialize.toast('Error in Connection', 5000);
            log(e);
        });
    };
}]);

app.controller('ntCntrllr', ['$filter', '$scope', '$rootScope', '$http', '$routeParams',
    'users', 'notify', '$sce', '$location', function ($filter, $scope, $rootScope, $http, $routeParams, users, notify, $sce, $location) {
    var b, s, f, d, n, i, m, p, r;
    $rootScope.pageTitle = $routeParams.username + ' - notification - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')($rootScope.pageTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.busy = true;
    if($rootScope.username === $routeParams.username){
        n = notify.notify();
        n.then(function(r){
            if (r.data !== '') {
                m = r.data.notification;
                for (i = 0; i < m.length; i++) {
                    if (typeof m !== 'undefined') {
                        if(m[i].postRelated){
                            m[i].postContent = $sce.trustAsHtml(m[i].postContent);
                        }
                        $scope.nots = m;
                    } else {
                        $location.url('/404');
                    }
                }
                $scope.busy = false;
            } else {
                $scope.noData = true;
            }
        }, function(e){
            /**
             * Error in connection page
             **/
            log(e);
        });
    }else{
        $location.url('/');
    }
    $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
        init();
    });
}]);

app.controller('fwrCntrllr', ['$filter', '$scope', '$rootScope', '$http', '$routeParams',
    'users', 'follower', '$location', '$timeout', function ($filter, $scope, $rootScope, $http, $routeParams, users, follower, $location, $timeout) {
    var u, f, m;
    $rootScope.pageTitle = $routeParams.username + ' - followers - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')($rootScope.pageTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.owner = $routeParams.username;
    $scope.busy = true;
    u = users.getUserByName($routeParams.username);
    u.then(function(r){
        if(r.data.users[0] !== undefined){
            f = follower.getFollowers(r.data.users[0].id);
            f.then(function(x){
                if (x.data === '') {
                    $scope.noData = true;
                } else {
                    $scope.noData = false;
                    $scope.ms = x.data.following;
                }
                $scope.busy = false;
            }, function(t){
                /**
                 * Error in connection page
                 **/
                Materialize.toast('Error in Connection!', 5000);
                log(t)
            });
        }else{
            Materialize.toast('This user Do not Exists!', 2000);
            location.href = '/404';
        }
    }, function(e){
        /**
         * Error in connection page
         **/
        log(e);
    });
}]);

app.controller('fwgCntrllr', ['$filter', '$scope', '$rootScope', '$routeParams', 'users',
    'follower', function ($filter, $scope, $rootScope, $routeParams, users, follower) {
    var u, f, m;
    $rootScope.pageTitle = $routeParams.username + ' - following - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')($rootScope.pageTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.busy = true;
    u = users.getUserByName($routeParams.username);
    u.then(function(r){
        if(r.data.users[0] !== undefined){
            f = follower.getFollowing(r.data.users[0].id);
            f.then(function(x){
                if (x.data === '') {
                    $scope.noData = true;
                } else {
                    $scope.noData = false;
                    $scope.fng = x.data.following;
                }
                $scope.busy = false;
            }, function(t){
                /**
                 * Error in connection page
                 **/
                Materialize.toast('Error in Connection!', 5000);
                log(t)
            });
        }else{
            Materialize.toast('This user Do not Exists!', 2000);
            location.href = '/404';
            $scope.noData = true;
        }
    }, function(e){
        /**
         * Error in connection page
         **/
        log(e);
    });
}]);

app.controller('stpCntrllr', ['$filter', '$scope', '$rootScope', '$routeParams', 'users',
    'post', '$sce', function ($filter, $scope, $rootScope, $routeParams, users, post, $sce) {
    var u, p, m, i;
    $rootScope.pageTitle = $routeParams.username + ' - starred posts - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')($rootScope.pageTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.busy = true;
    u = users.getUserByName($routeParams.username);
    u.then(function(r){
        p = post.starred(r.data.users[0].id);
        p.then(function(x){
            if (x.data === '') {
                $scope.noData = true;
            } else {
                $scope.noData = false;
                for (i = 0; i < x.data.starred_post.length; i++) {
                    x.data.starred_post[i].postContent = $sce.trustAsHtml(x.data.starred_post[i].postContent);
                }
                $scope.stps = x.data.starred_post;
            }
            $scope.busy = false;
        }, function(t){
            /**
             * Error in connection page
             **/
            log(t);
        });
    }, function(e){
        /**
         * Error in connection page
         **/
        log(e);
    });
}]);

app.controller('tgCntrllr', ['$filter', '$scope', '$rootScope', '$http',
    '$routeParams', '$sce', function ($filter, $scope, $rootScope, $http, $routeParams, $sce) {
    var t, tp;
    $rootScope.pageTitle = $routeParams.tag + ' - ' + baseTitle;
    $rootScope.pageKeywords = $filter('keywordise')($rootScope.pageTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.busy = true;
    $scope.tag = $routeParams.tag;
    o.url = baseUrl + 'tag.php?tag=' + $routeParams.tag;
    $http(o).then(function(r){
        tp = r.data.trending_hashtag[0].tagPosts;
        if (tp.length === 0) {
            $scope.noData = true;
        } else {
            $scope.noData = false;
            for (t = 0; t < tp.length; t++) {
                tp[t].content = $sce.trustAsHtml(tp[t].content);
            }
            $scope.tagPosts = tp;
        }
        $scope.busy = false;
    }, function(e){
        /**
         * Error in connection page
         **/
        log(e);
    });
}]);

app.controller('srchCntrllr', ['$http', '$scope', '$location', '$sce', 'users', 'post', 'gist', function ($http, $scope, $location, $sce, users, post, gist) { //, tag
    var q, u, p, g, i;
    $scope.isLoadingData = true;
    $scope.noSearchPostData = null;
    q = $location.search();
    $scope.searchString = q.q;
    u = users.getAllWithName(q.q);
    u.then(function(r){
        if (r.data.users.length > 0) {
            $scope.resUserLength = r.data.users.length;
            $scope.isLoadingData = false;
            $scope.noSearchUser = false;
            $scope.searchUserData = r.data.users;
        } else {
            $scope.noSearchUser = true;
            $scope.isLoadingData = false;
        }
    }, function(e){
        /**
         * Error in connection
         * **/
        log(e);
    });

    p = post.getAllPostsLike(q.q);
    p.then(function(r){
        if (r.data.posts.length > 0) {
            $scope.noSearchPostData = false;
            $scope.resPostLength = r.data.posts.length;
            for (i = 0; i < r.data.posts.length; i++) {
                r.data.posts[i].content = $sce.trustAsHtml(r.data.posts[i].content);
            }
            $scope.searchPostData = r.data.posts;
        } else {
            $scope.noSearchPostData = true;
        }
    }, function(e){
        log(e);
    });

    g = gist.getAllGistsLike(q.q);
    g.then(function(r){
        if (r.data.gists.length > 0) {
            $scope.noSearchGistData = false;
            $scope.resGistLength = r.data.gists.length;
            $scope.searchGistData = r.data.gists;
        } else {
            $scope.noSearchGistData = true;
        }
    }, function(e){
        log(e);
    });
}]);

app.controller('authCntrllr', ['$filter', '$scope', '$rootScope',
    function ($filter, $scope, $rootScope) {
    $rootScope.pageTitle = 'Signin - GistOut';
    $rootScope.pageKeywords = $filter('keywordise')($rootScope.pageTitle) + ', ' + baseKeywords;
    $rootScope.pageDescription = $rootScope.pageTitle + ' - ' + baseDescription;
    $rootScope.pageLocation = location.href;
    $scope.$on('is:logged:in', function (e, d) {
        if (d) {
            location.href = urlRoot;
            e.preventDefault();
        }
    });
    // var _ = $;
    // var _forgotPasswordArea = $('#forgotPasswordArea');
    // var _registerArea = $('#registerArea');
    // var _loginArea = $('#loginArea');
    // var _body = $('body');
    // var animate = 'animated shake';
    // var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationEnd animationEnd';
    //
    // var _forgotPassword = $('#forgotPassword');
    // var _signUpButton = $('#signUpButton');
    // var _signInButton = $('#signInButton');
    // var _loaderImg = '<img src="/docs/img/loaders/default2.gif" style="width: 20px; height: 20px;margin: 8px;">';
    //
    // // _signInButton.click(function () {
    // //     _registerArea.hide();
    // //     _loginArea.show();
    // // });
    // //
    // // _forgotPassword.click(function () {
    // //     _loginArea.hide();
    // //     _forgotPasswordArea.css({'margin-bottom':'150px'}).removeClass('hide').show();
    // // });
    // //
    // // _signUpButton.click(function(){
    // //     Materialize.toast('hello world', 2000);
    // //     _loginArea.hide();
    // //     _registerArea.removeClass('hide').show();
    // // });
    //
    // _body.on('click', '#signinSubmitBtn', function(){
    //     var _self = $(this);
    //     var username = $('#usernameInput').val();
    //     var password = $('#passwordInput').val();
    //     var signInform = $('#signInForm').serialize();
    //     _self.html(_loaderImg).attr('disabled','disabled');
    //     if(username === ''){
    //         var animate = 'animated shake';
    //         var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd animationEnd';
    //         username.addClass(animate).one(animationEnd, function () {
    //             username.removeClass(animate);
    //         });
    //         _self.html('Post');
    //         _self.removeAttr('disabled');
    //     }else if(password === ''){
    //         var animate = 'animated shake';
    //         var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd animationEnd';
    //         password.addClass(animate).one(animationEnd, function () {
    //             password.removeClass(animate);
    //         });
    //         _self.html('Post');
    //         _self.removeAttr('disabled');
    //     }else{
    //         $.ajax({
    //             url: '/signin.php',
    //             type: 'post',
    //             cache: false,
    //             data: signInform,
    //             success: function (res) {
    //                 log('status: ' + res);
    //                 // if(res == 1 || res == 3) // login was successful
    //                 // {
    //                 //     _self.html('Signed In').removeAttr('disabled');
    //                 //     // $scope.$emit('');
    //                 //     location.href = getRedirectParam();
    //                 //     // window.location.href = urlRoot;
    //                 // }
    //                 // else if(res == 2 || res == 4)
    //                 // {
    //                 //     Materialize.toast(' Error occurred. Invalid Request, Please Try Again !!', 5000);
    //                 //     // $('#errorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Houston We Have a Problem!</strong><br/> Error occurred Please Try Again !!</div>').removeClass('hid').show();
    //                 //     _self.html('Sign In').removeAttr('disabled');
    //                 // }
    //                 // else if(res == 0)
    //                 // {
    //                 //     Materialize.toast('The Email or Password You Entered Do not Exist, Please Input a Valid Email and Password', 5000);
    //                 //     // $('#errorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Houston We Have a Problem!</strong><br/> The Email or Password You Entered Do not Exist Please Input a Valid Email and Password</div>').removeClass('hid').show();
    //                 //     _self.html('Sign In').removeAttr('disabled');
    //                 // }
    //             },
    //             error: function (e) {
    //                 log(e);
    //             }
    //         });
    //         return false;
    //     }
    // });
    //
    // var checked = false;
    // _body.on('click', '#acceptTermCheck', function(){
    //     $(this).each(function(){
    //         if (checked == false) {
    //             $('#signUpSubmitBtn').removeAttr('disabled');
    //             checked = true;
    //         } else {
    //             $('#signUpSubmitBtn').attr('disabled', 'disabled');
    //             checked = false;
    //         }
    //     });
    // });
    //
    // _body.on('click', '#acceptModal', function () {
    //     $('#acceptTermCheck').click();
    //     $('#acceptClose').click();
    // });
    //
    // _body.on('click', '#signUpSubmitBtn', function (e) {
    //     e.preventDefault();
    //     var _self = $(this);
    //     var formData = $('#registerForm').serialize();
    //     _self.html(_loaderImg).attr('disabled','disabled');
    //     $.ajax({
    //         url: '/signup.php',
    //         type: 'POST',
    //         data: formData,
    //         success: function (res) {
    //             if(res == 2) // username already exists
    //             {
    //                 Materialize.toast('Oops!, The Username You Entered Already Exists Please Input Another Username', 5000);
    //                 // $('#regErrorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Oops!</strong><br/> The Username You Entered Already Exists Please Input Another Username</div>').removeClass('hid').show();
    //                 _self.html('Sign Up').removeAttr('disabled');
    //             }
    //             else if(res == 3) // email already exists
    //             {
    //                 Materialize.toast('Oops!, The Email You Entered Already Exists Please Input Another Email', 5000);
    //                 // $('#regErrorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Oops!</strong><br/> The Email You Entered Already Exists Please Input Another Email</div>').removeClass('hid').show();
    //                 _self.html('Sign Up').removeAttr('disabled');
    //             }
    //             else if(res == 0)
    //             {
    //                 Materialize.toast('Oop!, Error Signin you Up we are on it right now.', 5000);
    //                 // throw Error('Oop!, Error Signin you Up we are on iut right now.');
    //             }
    //             else
    //             {
    //                 Materialize.toast('<strong>Welcome!</strong><i class="material-icons" style="font-size: 50px; color: #00bfa5;">check_circle</i> Successfully Registered! Verification message has been sent to the email you provided, Please verify your Account.<br/><div class="small">Redirected in 5 sec...</div>', 5000);
    //                 _self.html('Signed Up');
    //                 setTimeout(function () {
    //                     window.location.href = urlRoot;
    //                 }, 5000);
    //             }
    //         }
    //     });
    //     // }
    //     return false;
    // });
    //
    // function checkInput(_self, username, email, password, confirmPassword){
    //     if(username == '')
    //     {
    //         $('#regUsernameInput').addClass(animate).one(animationEnd, function() {
    //             $('#regUsernameInput').removeClass(animate);
    //         });
    //         _self.html('Sign Up').removeAttr('disabled');
    //         return false;
    //     }
    //     else if (email == '')
    //     {
    //         $('#regEmailInput').addClass(animate).one(animationEnd, function() {
    //             $('#regEmailInput').removeClass(animate);
    //         });
    //         _self.html('Sign Up').removeAttr('disabled');
    //         return false;
    //     }
    //     else if(password == '')
    //     {
    //         $('#regPasswordInput').addClass(animate).one(animationEnd, function() {
    //             $('#regPasswordInput').removeClass(animate);
    //         });
    //         _self.html('Sign Up').removeAttr('disabled');
    //         return false;
    //     }
    //     else if (password != confirmPassword)
    //     {
    //         $('#regErrorMsg').html('<div class="small alert alert-danger alert-dismissible fade show" role="alert" xmlns="http://www.w3.org/1999/html"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Houston We Have a Problem!</strong><br/> The passwords you provided do not match</div>').removeClass('hid').show();
    //         _self.html('Sign Up').removeAttr('disabled');
    //         return false;
    //     }
    //     else
    //     {
    //         return true;
    //     }
    // }

    // var paramDomain;
    // var direct = decodeURIComponent($location.search);
    // paramDomain = direct.split('=');
    // log(paramDomain[1]);
    // log($location.search().redirect);

    // $scope.$on('$routeChangeStart', function (e) {
    //     if(!$scope.isLoggedIn){
    //         log('Deny');
    //         e.preventDefault();
    //         $location.path(urlRoot);
    //     }else{
    //         log('Allow');
    //     }
    // });

    // var _ = ang.element;
    // var forgotPasswordArea = _('#forgotPasswordArea');
    // var registerArea = _('#registerArea');
    // var loginArea = _('#loginArea');
    // var body = _('body');
    // var animate = 'animated shake';
    // var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationEnd animationEnd';
    //
    //
    // var forgotPassword = _('#forgotPassword');
    // var signUpButton = _('#signUpButton');
    // var signInButton = _('#signInButton');
    // var loaderImg = '<img src="/docs/img/loaders/default2.gif" style="width: 20px; height: 20px;">';
    //
    // $scope.goAuth = ()=>{
    //     alert('log in');
    // };
    // $scope.showSignUp = function () {
    //     // alert('hello world');
    //     // signInButton.click(function () {
    //     //     registerArea.hide();
    //     //     loginArea.show();
    //     // });
    //     Materialize.toast('hello world', 2000);
    //     loginArea.hide();
    //     registerArea.removeClass('hide').show();
    // };
    // $scope.showSignIn = function () {
    //     // alert('hello world');
    //     registerArea.hide();
    //     loginArea.show();
    //     Materialize.toast('hello world', 2000);
    // }
}]);























function resizeBase64Img(base64, width, height){
    var canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    var context = canvas.getContext('2d');
    var deferred = $.Deferred();
    $('<img/>').attr('src', 'data:image/jpg;base64,' + base64).load(function () {
        context.scale(width / this.width, height / this.height);
        context.drawImage(this, 0, 0);
        deferred.resolve($('<img/>').attr('src', canvas.toDataUrl()));
    });
    return deferred.promise();
}

// function isOnline($http){
//     o.url = '/test.php';
//     $http(o).then(
//         function(r){
//             if(r.statusText){
//                 return true;
//             }
//         }, function (e) {
//             return false;
//         }
//     );
    // var xhr = XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHttp');
    // xhr.onload = function(){
    //     // if(yes instanceof Function){
    //     //     yes();
    //     // }
    //     return true;
    // };
    // xhr.onerror = function(){
    //     // if(no instanceof Function){
    //     //     no();
    //     // }
    //     return false;
    // };
    // xhr.open("GET", "/test.php", true);
    // xhr.send();
// }

function resetFileElement(ele) {
    ele.val('');
    ele.wrap('<form>').parent('form').trigger('reset');
    ele.unwrap();
    ele.prop('files')[0] = null;
    ele.replaceWith(ele.clone());
    $('._2squrbxprvw').attr('style', 'background-image: url();');
}

var inArray = function(needle, ayStack) {
    var i;
    for(i = 0; i < ayStack.length; i++){
        if(needle == ayStack[i]){
            return true;
        }
    }
    return false;
};

function doesConnectionExist() {
    var xhr = new XMLHttpRequest();
    var file = "https://gistout.com/docs/img/blank.gif";
    var randomNum = Math.round(Math.random() * 10000);

    xhr.open('HEAD', file + "?rand=" + randomNum, true);
    xhr.send();

    xhr.addEventListener("readystatechange", processRequest, false);

    function processRequest(e) {
        if (xhr.readyState == 4) {
            if (xhr.status >= 200 && xhr.status < 304) {
                Materialize.toast("connection exists!");
            } else {
                Materialize.toast("Error in connection");
            }
        }
    }
}

//assign personal functions
function log(data) {
    console.log(data);
}

function init() {
    // setTimeout(function(){
    //     $('body').attr('data-wdt-emoji-bundle', 'google');
    // }, 5000);
    $('.button-collapse').sideNav({
        closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true // Choose whether you can drag to open on touch screens
    });$('.tooltipped').tooltip(); $('ul.tabs').tabs(); $('.modal').modal(); $('.materialboxed').materialbox(); $('.dropdown-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: true, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 10, // Spacing from edge
        belowOrigin: false, // Displays dropdown below the button
        // alignment: 'bb', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
    }
    ); $('input.autocomplete').autocomplete(
        // {
        //     data: {
        //         "Apple": null,
        //         "Microsoft": null,
        //         "Google": 'http://placehold.it/250x250'
        //     },
        //     limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
        // }
    );$('._2tp').mintScrollbar({wheelSpeed: 80});/*$('.timeago').timeago();*/
}

// Unique ID
var guid = function(){
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
};

function s4() {
    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
}

function gistPlaceHolder(a) {
    var d, $p, $l;
    d = '<section class="card pholder">';
    $p = (a > 5) ? 5 : a;
    $p = ($p === 0) ? 1 : $p;
    for ($l = 1; $l <= $p; $l++) {
        d += '<article class="loader-background">';
        d += '<div class="a"></div>';
        d += '<div class="b"></div>';
        d += '<div class="c"></div>';
        d += '<div class="d"></div>';
        d += '<div class="e"></div>';
        d += '<div class="f"></div>';
        d += '<div class="g"></div>';
        d += '<div class="h"></div>';
        d += '<div class="i"></div>';
        d += '<div class="j"></div>';
        d += '<div class="k"></div>';
        d += '<div class="l"></div>';
        d += '<div class="m"></div>';
        d += '</article>';
        if ($l !== $p)
            d += '<hr/>';
    }
    d += '</section>';
    // return d;
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

var getRedirectParam = function () {
    var paramDomain;
    var direct = decodeURIComponent(window.location.search.substring(1));
    paramDomain = direct.split('=');
    return paramDomain[1];
};

var encodifyURI = function (uri) {
    return uri.replace(' ', '+');
};

var isInt = function (n) {
    return Number(n) === n && n % 1 === 0;
};

var isFloat = function (n) {
    return Number(n) === n && n % 1 !== 0;
};

var contains = function(needle) {
    // Per spec, the way to identify NaN is that it is not equal to itself
    var findNaN = needle !== needle;
    var indexOf;

    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
        indexOf = Array.prototype.indexOf;
    } else {
        indexOf = function(needle) {
            var i = -1, index = -1;

            for(i = 0; i < this.length; i++) {
                var item = this[i];

                if((findNaN && item !== item) || item === needle) {
                    index = i;
                    break;
                }
            }

            return index;
        };
    }

    return indexOf.call(this, needle) > -1;
};

var starColor = function () {
    return [
        {
            name: 'Aluminum',
            color: 'grey-text lighten-2',
        }, {
            name: 'Topaz',
            color: 'blue-text lighten-1',
        }, {
            name: 'Bronze',
            color: 'orange-text darken-2',
        }, {
            name: 'Silver',
            color: 'grey-text',
        }, {
            name: 'Gold',
            color: 'amber-text darken-3',
        }, {
            name: 'Platinum',
            color: 'grey-text lighten-4',
        }, {
            name: 'Diamond',
            color: 'grey-text lighten-5',
        }, {
            name: 'Adamantium',
            color: 'grey-text darken-1',
        }
    ];
};

var starCount = function (strCount) {
    var d, i, r = 0.5;
    var star = [];
    if (isFloat(strCount)) {
        d = strCount - r;
        for (var s = 0; s < 8; s++) {
            if (s >= d + 1) {
                star.push({ color: starColor()[s].color, icon: 'star_border' });
            } else if ((s == d)) {
                star.push({ color: starColor()[s].color, icon: 'star_half' });
            } else if (s < d) {
                star.push({ color: starColor()[s].color, icon: 'star' });
            }
        }
    } else {
        for (var s = 0; s < 8; s++) {
            if (s >= strCount) {
                star.push({ color: starColor()[s].color, icon: 'star_border' });
            } else if (s < strCount) {
                star.push({ color: starColor()[s].color, icon: 'star' });
            }
        }
    }
    return star;
};

////////////////////////////////////////////////////
/**
 * writeTextFile write data to file on hard drive
 * @param  string  filepath   Path to file on hard drive
 * @param  sring   output     Data to be written
 */
function writeTextFile(fileUrl, out) {
    var txtFile = new File(fileUrl);
    txtFile.open("w"); //
    txtFile.writeln(out);
    txtFile.close();
}

////////////////////////////////////////////////////
/**
 * readTextFile read data from file
 * @param  string   filepath   Path to file on hard drive
 * @return string              String with file data
 */
function readTextFile(filePath) {
    var str = "";
    var txtFile = new File(filePath);
    txtFile.open("r");
    while (!txtFile.eof) {
        // read each line of text
        str += txtFile.readln() + "\n";
    }
    return str;
}

function WriteFile(){

    var fh = fopen("c:\\MyFile.txt", 3); // Open the file for writing

    if(fh!=-1) // If the file has been successfully opened
    {
        var str = "Some text goes here...";
        fwrite(fh, str); // Write the string to a file
        fclose(fh); // Close the file
    }

}

////////////////////////////////////////////////////