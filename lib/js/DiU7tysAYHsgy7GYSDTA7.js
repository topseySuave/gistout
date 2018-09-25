/**
 * Created by Daniel on 6/25/2017.
 */
$(function () {
    /*--------- Define Variables ------------*/
    var g = $;
    var body = g('body');
    var btn_colps = g('.button-collapse');
    var fixed_act_btn = g('.fixed-action-btn');
    var toolbar = g('.fixed-action-btn.toolbar');
    var modal = g('.modal');
    var EditorContainer = g('.Editor-container');
    var quoteHolder = g('#qoute-holder');
    const loaderImg = '<img src="/docs/img/loaders/default.gif" id="loaderImg" style="width: 20px;margin: 8px;"/>';
    const loaderImg2 = '<img src="/docs/img/loaders/default2.gif" style="width: 20px; height: 20px;margin: 8px;">';
    var gists = {};
    function copyToClipBoard(link){
        var temp = $('<input>');
        body.append(temp);
        temp.val(link).select();
        document.execCommand('copy');
        temp.remove();
        return true;
    }

    // var notify = "/docs/audio/notify.ogg";
    var blop = "/docs/audio/Blop.mp3";
    // var pling = "/docs/audio/Pling.mp3";
    // var pop = "/docs/audio/Gum_Bubble_Pop.mp3";

    var audio = new Audio(blop);
    /*---------------------------------------*/
    EditorContainer.find('.Editor-editor').css({
        'height': 'inherit'
    });
    /*--------- Plugin Initialization ---------*/
    //Waves.attach('ul li');
    // fixed_act_btn.openFAB();
    // fixed_act_btn.closeFAB();
    // toolbar.openToolbar();
    // toolbar.closeToolbar();
    modal.modal();
    /*
    * @tabs You can programmatically trigger a tab change with our select_tab method.
    * You have to input the id of the tab you want to switch to.
    * In the case of our demo it would be either test1, test2, test3, or test4.
    * $('ul.tabs').tabs('select_tab', 'tab_id');
    * */
    g('ul.tabs').tabs();
    g('.tooltipped').tooltip();

    //initialize emoji picker for editor
    // window.emojiPicker = new EmojiPicker({
    //     emojiable_selector: '[data-emojiable=true]',
    //     assetsPath: '/docs/img',
    //     popupButtonClasses: 'mdi mdi-face'
    // });
    // window.emojiPicker.discover();
    /*------------------------------------------*/

    /*--------- Click events handlers -------*/
    g('._2shwmdl').modal();

    // $('.Editor-editor').on('keyup keypress bind change input', function(e){
    //     // alert('typing');
    //     var content = $(this).html();
    //     content = emojione.toImage(content);
    //     $('#outputArea').val(content);
        // if(e.which == 13){
        //     $('#add_post').click();
        //     return false;
        // }
    // });

    body.on('click', '#edit-profile', function () {
        g('#profile-preview').fadeOut('slow');
        // g('#myPostArea').fadeOut('slow').css({'display':'none'});
        g('#profile-edit-form').fadeIn('slow');
    });

    body.on('click', '#bck-to-profile-preview', function(e){
        e.preventDefault();
        // alert('hello world..!!!');
        g('#profile-edit-form').fadeOut('slow');
        // g('#myPostArea').fadeIn('slow').css({'display':'inherit'});
        g('#profile-preview').fadeIn('slow');
    });

    body.on('click', '#case--copy-link', function(){
        var link = location.href;
        if(copyToClipBoard(link)){
            Materialize.toast('Link Copied', 4000);
        }
        return false;
    });

    body.on('click', '.role', function(){
        $(this).each(function(){
            // alert('role');
            var pop = $('#box-pop');
            pop.css({'transform': 'translateY(0px)'});
            g(this).regulateData();
            var pId = g(this).data('purpose');
            g(document).on('click',function(e){
                var boxPop = g('#box-pop').children().find(e.target);
                var fixedBtn = g('.fixed-action-btn').children().find(e.target);
                var emojiPopBox = g('.wdt-emoji-popup').children().find(e.target);
                var quoteBtn = g('#quote-'+pId);
                // log(e.target);
                if(boxPop[0] || fixedBtn[0] || emojiPopBox[0]){
                    g('.fixed-action-btn').addClass('animated bounceOutDown');
                }else{
                    if(quoteBtn[0] == e.target){
                        // quoteBtn.regulateData();
                        pop.css({'transform': 'translateY(0px)'});
                        g('.fixed-action-btn').addClass('animated bounceOutDown');
                    }else{
                        pop.css({'transform': 'translateY(-1000px)'});
                        g('.fixed-action-btn').removeClass('bounceOutDown');
                    }
                }
            });
        });
    });

    // add_post
    // body.on('submit', '#contentData', function($scope){
        // var $this = g(this);
        // var quote_content = g('.emoji-wysiwyg-editor').html();
        // // var postID = $('.Editor-editor').data('post-id');
        // var postCount = parseInt(g('#posts-count').html());
        // var gCountPost = parseInt(g('#g-count-post').html());
        // var formData = new FormData();
        // log(formData);

        // console.log('hello');
        // preloaderHtml
        // var preloaderHolder = g('<div></div>');
        // g(this).html(loaderImg2);
        // $this.attr('disabled','disabled');
        // if(quote_content === '')
        // {
        //     // alert('you can\'t pass an empty post');
        //     // alert('you cannot pass an empty conversation');
        //     var animate = 'animated shake';
        //     var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationEnd animationEnd';
        //     EditorContainer.addClass(animate).one(animationEnd, function() {
        //         EditorContainer.removeClass(animate);
        //     });
        //     $this.html('Post');
        //     $this.removeAttr('disabled');
        // }
        // else
        // {
        //     var datRole = EditorContainer.data('role');
        //     if(datRole === 'post'){
        //         var sess = EditorContainer.data('sess');
        //         var gistID = EditorContainer.data('gist-id');
        //         var data = 'quoteContent=' + quote_content + '&gist_id=' + gistID + '&sess=' + sess;
        //
        //         // log(quote_content);
        //         g.ajax({
        //             url: '/rest/requests/create-post.php',
        //             type: 'POST',
        //             data: data,
        //             success: function(x){
        //                 // $scope.pData = JSON.parse(x);
        //                 log($scope);
        //                 // if(x == 0)
        //                 // {
        //                 //     toast('Error Posting');
        //                 //     $this.html('Post');
        //                 //     $this.removeAttr('disabled');
        //                 // }
        //                 // else if(x == 2)
        //                 // {
        //                 //     toast('Error Posting.. Already Exist');
        //                 //     $this.html('Post');
        //                 //     $this.removeAttr('disabled');
        //                 // }
        //                 // else
        //                 // {
        //                 //     // alert(x);
        //                 //     g('#list-group-container').append(x);
        //                 //     g('#posts-count').html(postCount + 1);
        //                 //     g('#g-count-post').html(gCountPost + 1);
        //                 //     g('.Editor-editor').html(' ');
        //                 //     g('.close').click();
        //                 //     $this.html('Post');
        //                 //     $this.removeAttr('disabled');
        //                 // }
        //             }
        //         });
        //     }
        //     else if(datRole === 'quote')
        //     {
        //         var id = EditorContainer.data('purpose');
        //         var postUserId = EditorContainer.data('purposeful');
        //         var sess = EditorContainer.data('sess');
        //         var gistID = EditorContainer.data('gist-id');
        //
        //         var data = 'quoteContent=' + quote_content + '&gist_id=' + gistID + '&postID=' + id + '&postUserId=' + postUserId + '&sess=' + sess;
        //         g.ajax({
        //             url: '/rest/requests/create-quote.php',
        //             type: 'POST',
        //             data: data,
        //             success: function(x){
        //                 // alert(x);
        //                 if(x == 0 || x == 2)
        //                 {
        //                     toast('Error Posting');
        //                     $this.html('Post');
        //                     $this.removeAttr('disabled');
        //                 }
        //                 else
        //                 {
        //                     // alert(x);
        //                     g('#list-group-container').append(x);
        //                     g('#posts-count').html(postCount + 1);
        //                     g('#g-count-post').html(gCountPost + 1);
        //                     g('.Editor-editor').html(' ');
        //                     g('.close').click();
        //                     $this.html('Post');
        //                     $this.removeAttr('disabled');
        //                 }
        //             }
        //         });
        //     }
        //     else if(datRole === 'gist')
        //     {
        //         var title = g('#gistTitle').val();
        //         var sess = EditorContainer.data('sess');
        //         var catID = EditorContainer.data('cat-id');
        //         var data = 'quoteContent=' + quote_content + '&title='+ title +'&cat_id=' + catID + '&sess=' + sess;
        //
        //         // console.log(data);
        //         if(title == '' || title < 1)
        //         {
        //             // alert('you cannot pass an empty conversation');
        //             var animate = 'animated shake';
        //             var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationEnd animationEnd';
        //             g('#gist-title-input').addClass(animate).one(animationEnd, function() {
        //                 g('#gist-title-input').removeClass(animate);
        //             });
        //         }
        //         else
        //         {
        //             g.ajax({
        //                 url: 'rest/requests/create-gist.php',
        //                 type: 'POST',
        //                 data: data,
        //                 success: function(x){
        //                     // console.log(x);
        //                     if(x == 0)
        //                     {
        //                         toast('Error Adding Gist');
        //                         $this.html('create');
        //                         $this.removeAttr('disabled');
        //                     }
        //                     else if(x == 2)
        //                     {
        //                         toast('Error Gisting.. Already Exist');
        //                         $this.html('create');
        //                         $this.removeAttr('disabled');
        //                     }
        //                     else
        //                     {
        //                         // alert(x);
        //                         // $('#card-column').append(x);
        //                         g('.Editor-editor').html('');
        //                         g('#gistTitle').val('');
        //                         // $('.close').click();
        //                         $this.html('Post');
        //                         $this.removeAttr('disabled');
        //                         location.reload();
        //                     }
        //                 }
        //             });
        //         }
        //     }
        // }
    // });

    //follow btn
    body.on('click', '#follow-btn', function(e){
        e.preventDefault();
        // alert('hello world')
        var $this = g(this);
        $this.html('<i id="follow-btn-icon" class="material-icons">check</i>');
        // $this.removeClass('btn-outline-primary');
        // $this.addClass('btn-outline-success');
        $this.attr('id','following-btn');
        var role = $this.data('role');
        if(role == 'gist')
        {
            var sess = $this.data('sess');
            var gistId = $this.data('gist-id');
            var gistUser = $this.data('gist-user');
            var followers = $this.data('followers');

            var data = 'sess=' + sess + '&gistId=' + gistId + '&gistUser=' + gistUser + '&followers=' + followers;

            g.ajax({
                url: '/rest/requests/follow.php',
                type: 'POST',
                data: data,
                success: function(xhr){
                    // alert(xhr);
                    if (xhr == 0) {
                        $this.html('<i id="follow-btn-icon" class="material-icons">person_add</i>');
                        $this.attr('id', 'follow-btn');
                    } else if (xhr == 2) {
                        $this.html('<i id="follow-btn-icon" class="material-icons">person_add</i>');
                        $this.attr('id', 'follow-btn');
                    } else {
                    }
                }
            });
        }
        else if(role == 'user')
        {
            var sess = $this.data('sess');
            var follow = $this.data('follow');
            var purpose = $this.data('purpose');
            var $followers = g('#user-followers').html();
            $followers = parseInt($followers) + 1;
            var data = 'sess=' + sess + '&follow=' + follow + '&purpose=' + purpose;
            g.ajax({
                url: '/rest/requests/follow-user.php',
                type: 'POST',
                data: data,
                success: function(xhr){
                    // alert(xhr);
                    if (xhr == 0) {
                        $this.html('<i id="follow-btn-icon" class="material-icons">check</i>');
                        $this.attr('id', 'follow-btn');
                    } else if (xhr == 2) {
                        $this.html('<i id="follow-btn-icon" class="material-icons">check</i>');
                        $this.attr('id', 'follow-btn');
                    } else if(xhr == 3){
                        $this.html('<i id="follow-btn-icon" class="material-icons">check</i>');
                        $this.attr('id', 'follow-btn');
                    }else{
                        $('#user-followers').html($followers);
                        $this.attr('data-purpose', 'unfollow');
                    }
                }
            });
        }
    });

    body.on('click', '#following-btn', function(e){
        e.preventDefault();
        // alert('hello world')
        var $this = g(this);
        $this.html('<i id="follow-btn-icon" class="material-icons">person_add</i>');
        $this.attr('id','follow-btn');
        var role = $this.data('role');

        if(role == 'gist')
        {
            var sess = $this.data('sess');
            var gistId = $this.data('gist-id');
            var gistUser = $this.data('gist-user');
            var followers = $this.data('followers');

            var data = 'sess='+sess+'&gistId='+gistId+'&gistUser='+gistUser+'&followers='+followers;

            g.ajax({
                url: '/rest/requests/unfollow.php',
                type: 'POST',
                data: data,
                success: function(xhr){
                    // alert(xhr);
                    if(xhr == 0){
                        $this.html('<i id="follow-btn-icon" class="material-icons">check</i>');
                        $this.attr('id','following-btn');
                    }else if(xhr == 2){
                        $this.html('<i id="follow-btn-icon" class="material-icons">check</i>');
                        $this.attr('id','following-btn');
                    }else{}
                }
            });
        }
        else if(role == 'user')
        {
            var sess = $this.data('sess');
            var follow = $this.data('follow');
            var purpose = $this.data('purpose');
            var $followers = g('#user-followers').html();
            $followers = parseInt($followers) - 1;
            var data = 'sess=' + sess + '&follow=' + follow + '&purpose=' + purpose;

            g.ajax({
                url: '/rest/requests/unfollow-user.php',
                type: 'POST',
                data: data,
                success: function(xhr){
                    // alert(xhr);
                    if (xhr == 0) {
                        $this.html('<i id="follow-btn-icon" class="material-icons">person_add</i>');
                        $this.attr('id', 'follow-btn');
                    } else if (xhr == 2) {
                        $this.html('<i id="follow-btn-icon" class="material-icons">person_add</i>');
                        $this.attr('id', 'follow-btn');
                    }else{
                        g('#user-followers').html($followers);
                        $this.attr('data-purpose', 'accept');
                    }
                }
            });
        }
    });

    //like btn
    body.on('click', '#like-btn', function(){
        var count_like = parseInt($(this).find('#count-like').html());
        count_like++;
        $(this).find('#count-like').html(count_like);
        $(this).attr('data-tooltip', count_like + ' likes');
        // var i = $(this).attr('id').substring(1);//get the index of button
        audio.play();//play corresponding audio

        // $(this).html('');
        $(this).removeClass('light-blue-text');
        $(this).addClass('light-green-text');
        $(this).addClass('animated bounceIn');
        $(this).attr('id','liked-btn');

        var gistID = $(this).data('gist-id');
        var gUserID = $(this).data('user-id');
        var sessUserID = $(this).data('sess-user-id');
        var postUserID = $(this).data('post-user-id');
        var postID = $(this).data('post-id');

        var data = 'gistID='+gistID+'&gUserID='+gUserID+'&sessUserID='+sessUserID+'&postID='+postID+'&postUserID='+postUserID;
        // var res = gistAjax('rest/requests/like.php', 'POST', data);
        if(gistID == '')
        {
            // log('this is a post button with the data: ' + data);
            // alert(' this is a post');
            $.ajax({
                url: '/rest/requests/like.php',
                type: 'POST',
                data: data,
                success: function(XHRresponse){
                    // alert(XHRresponse);
                    if(XHRresponse == 0){
                        // $(this).html('<i class="mdi mdi-thumb-up"></i> Likes');
                        $(this).removeClass('light-green-text');
                        $(this).addClass('light-blue-text');
                        $(this).attr('id','like-btn');
                        $(this).removeClass('animated bounceIn');
                    }
                }
            });
        }
        else
        {
            // log('this is a gist button with the data: ' + data);
            $.ajax({
                url: '/rest/requests/like-gist.php',
                type: 'POST',
                data: data,
                success: function(x){
                    // alert(x);
                    if(x == 0){
                        // $(this).html('Likes');
                        $(this).removeClass('light-green-text');
                        $(this).addClass('light-blue-text');
                        $(this).attr('id','like-btn');
                        $(this).removeClass('animated bounceIn');
                    }
                }
            });
        }
    });

    body.on('click', '#liked-btn', function(){
        // alert('hello world')
        var count_unlike = parseInt($(this).find('#count-like').html());
        count_unlike--;
        $(this).find('#count-like').html(count_unlike);
        $(this).attr('data-tooltip', count_unlike + ' likes');
        // $(this).html('<i class="mdi mdi-thumb-up"></i> Likes');
        $(this).removeClass('light-green-text');
        $(this).addClass('light-blue-text');
        $(this).attr('id','like-btn');
        $(this).removeClass('animated bounceIn');

        var gistID = $(this).data('gist-id');
        var gUserID = $(this).data('user-id');
        var sessUserID = $(this).data('sess-user-id');
        var postUserID = $(this).data('post-user-id');
        var postID = $(this).data('post-id');

        var data = 'gistID='+gistID+'&gUserID='+gUserID+'&sessUserID='+sessUserID+'&postID='+postID+'&postUserID='+postUserID;
        // var res = gistAjax('rest/requests/like.php', 'POST', data);
        if(gistID == '')
        {
            // alert(' this is a post');
            $.ajax({
                url: '/rest/requests/unlike.php',
                type: 'POST',
                data: data,
                success: function(x){
                    // alert(x);
                    if(x == 0){
                        // $(this).html('<i class="mdi mdi-thumb-up"></i> Liked');
                        $(this).removeClass('light-blue-text');
                        $(this).addClass('light-green-text');
                        $(this).addClass('animated bounceIn');
                        $(this).attr('id','liked-btn');
                    }
                }
            });
        }
        else
        {
            // alert('this is a gist button');
            $.ajax({
                url: '/rest/requests/unlike-gist.php',
                type: 'POST',
                data: data,
                success: function(x){
                    // alert(x);
                    if(x == 0){
                        // $(this).html('Liked');
                        $(this).removeClass('light-blue-text');
                        $(this).addClass('light-green-text');
                        $(this).addClass('animated bounceIn');
                        $(this).attr('id','liked-btn');
                    }
                }
            });
        }
    });

    body.on('click', '#gist-s-p', function(){
        // alert('alert');
        var self = $(this);
        self.children('i').html('star');
        self.data('tooltip', 'unstar this post');
        self.attr('id', 'gist-sd-p');

        var ID = self.data('post-id');
        var postUID = self.data('post-user');
        var sess = self.data('sess');
        var data = 'id='+ID+'&post_user='+postUID+'&sess='+sess+'&purpose=star-post';

        // alert(data);
        $.ajax({
            url: '/rest/requests/star-post.php',
            type: 'POST',
            data: data,
            success: function(xhr){
                // alert(xhr);
                if(xhr == 0){
                    self.children('i').html('star_border');
                    self.data('tooltip', 'star this post');
                    self.attr('id', 'gist-s-p');
                }else if(xhr == 2){
                    self.children('i').html('star_border');
                    self.data('tooltip', 'star this post');
                    self.attr('id', 'gist-s-p');
                }else{}
            }
        });
    });

    body.on('click', '#gist-sd-p', function(){
        // alert('alert');
        var self = $(this);
        self.children('i').html('star_border');
        self.data('tooltip', 'star this post');
        self.attr('id', 'gist-s-p');

        var ID = self.data('post-id');
        var postUID = self.data('post-user');
        var sess = self.data('sess');
        var data = 'id='+ID+'&post_user='+postUID+'&sess='+sess+'&purpose=unstar-post';

        // alert(data);
        $.ajax({
            url: 'rest/requests/star-post.php',
            type: 'POST',
            data: data,
            success: function(xhr){
                if(xhr == 0){
                    self.children('i').html('star');
                    self.data('tooltip', 'unstar this post');
                    self.attr('id', 'gist-sd-p');
                }else if(xhr == 2){
                    self.children('i').html('star');
                    self.data('tooltip', 'unstar this post');
                    self.attr('id', 'gist-sd-p');
                }else{}
            },
            error: function(){}
        });
    });

    body.on('click', '#case--inappropriate, #case--spam, #case--insult', function(e){
        var $this = $(this);
        $this.each(function(){
            // alert('hello world');
            var caseP = $this.data('case');
            var pId = $this.parents('.dropdown-content').data('p-Id');
            var sess = $this.parents('.dropdown-content').data('sess');
            var post_user = $this.parents('.dropdown-content').data('post_user');

            var data = 'case=' + caseP + '&post_id=' + pId + '&sess=' + sess + '&post_user=' + post_user;
            // log(data);

            // Make the ajax request
            $.ajax({
                url: '/rest/requests/report-post.php',
                type: 'POST',
                data: data,
                success: function(x){
                    if(x == 1)
                    {
                        Materialize.toast('<strong>Thanks for your Report! </strong> Your Report have been received and is being taking care of.', 5000);
                    }
                    else if(x == 0)
                    {
                        Materialize.toast('<strong>Oops! </strong> You have Already sent a report.', 5000);
                    }
                    else
                    {
                        Materialize.toast('<strong>Oops! </strong> You have Already sent a report.', 5000);
                    }
                }
            });
        });
        return false;
    });

    //upload profile image
    body.on('click', '#profile-image-upload-btn', function(){
        g('#profile-upload-form-btn').click();
    });

    body.on('click', '#imgBtn', function () {
        g('#imgContent').click();
    });
    /*-------- End Click events handlers ------*/

    /*----- define built in plugins -------*/
    g.fn.regulateData = function () {
        // alert('hello world');
        var ds = g(this);
        ds.each(function () {
            var dataRole = ds.data('modal-role');
            // g('#myModalLabel').html('Compose '+ dataRole);
            // alert(dataRole);
            if(dataRole == 'post')
            {
                // alert(dataRole);
                g('#qoute-holder').css({'display': 'none'});
                g('#gist-title-input').css({'display': 'none'});
                var sess = g(this).data('sess');
                var gistID = g(this).data('gist-id');
                var gistUserID = g(this).data('gist-user-id');
                // dataPArr.push(dataRole, sess, gistID);
                // alert(gistID);
                g('.Editor-container').attr('data-sess', sess);
                g('.Editor-container').attr('data-gist-id', gistID);
                g('.Editor-container').attr('data-gist-user-id', gistUserID);
                g('.Editor-container').attr('data-role', 'post');
            }
            else if(dataRole == 'gist')
            {
                g('#qoute-holder').css({'display': 'none'});
                g('#gist-title-input').css({'display':'inherit'});
                var sess = g(this).data('sess');
                var catID = g(this).data('cat-id');

                g('.Editor-container').attr('data-sess', sess);
                g('.Editor-container').attr('data-cat-id', catID);
                g('.Editor-container').attr('data-role', 'gist');
            }
            else
            {
                // alert(dataRole);
                g('#qoute-holder').css({'display': 'inherit'});
                g('#gist-title-input').css({'display': 'none'});
                var id = g(this).data('purpose');
                var postUserId = g(this).data('purposeful');
                var sess = g(this).data('sess');
                var gistID = g(this).data('gist-id');
                // var data = 'postId = '+id+' & postUserId = '+postUserId+' & sessionUser = '+sess;
                g('.Editor-container').attr('data-purpose', id);
                g('.Editor-container').attr('data-purposeful', postUserId);
                g('.Editor-container').attr('data-sess', sess);
                g('.Editor-container').attr('data-gist-id', gistID);
                g('.Editor-container').attr('data-role', 'quote');
                // dataArr.push(dataRole, id,postUserId,sess,gistID);

                // alert(dataArr + ' ' + dataArr[0]);
                var i = guid();
                var qtHldrPrnt = g('<div id="'+ i +'"></div>');
                var postTbQuoted = g('#list-group-'+id).html();
                g('#qoute-holder').html(qtHldrPrnt).addClass('collection');
                g('#'+i).addClass('collection-item avatar').html(postTbQuoted).css({
                    'display':'inherit',
                    'min-height': '10px'
                }).attr('disabled');
                // $('.Editor-editor').attr('data-post-id',id);
                g('#qoute-holder').find('._2ftrarea').remove();
                g('#qoute-holder').find('.secondary-content').remove();
                g('#qoute-holder').find('.qouted').remove();
            }
        });
    };

    var previewer = function (inputBtn, options){
        var defaults = {
            imgId: null,
            imgSrc: false,
            backId: null,
            background: false,
            size: 500000
        };
        options = g.extend(defaults, options);
        body.on('change', inputBtn, function() {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
            if (/^image/.test(files[0].type)) { // only image file
                if(files[0].size < options.size){
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function() { // set image data as background of div
                        if(options.imgSrc){
                            g(options.imgId).attr('src', this.result);
                        }
                        if(options.background){
                            g(options.backId).attr("style", "background-image: url("+this.result+");");
                        }
                        // $('#imgUpload').submit();
                        // $('#subImgUpload').click();
                    }
                }else{
                    Materialize.toast('File too large', 5000);
                }
            }
        });
    };

    //preview profile upload image
    var imgUploadForm = $('#imgUpload');
    var subImgUpload = $('#subImgUpload');

    previewer('#profile-upload-form-btn', {
        imgId: '#profile-preview-image',
        imgSrc: true,
        backId: '#profile-preview-image-cover',
        background: true
    });

    previewer('#imgContent', {
        backId: '._2squrbxprvw',
        background: true
    });

    // body.on('click', subImgUpload, function () {
    //     alert('bbugggssss');
    // }
    // );

    // body.on('submit', '#imgUpload', function(e){
    //     e.preventDefault();
    //     $.ajax({
    //         url: '/gistout-material/api/update.profile.php',
    //         method: 'POST',
    //         data: new FormData(this),
    //         // contentType: 'multipart/form-data',
    //         cache: false,
    //         processData: false,
    //         success: function(res){
    //             log(res);
                // if(res == 5){ // 5
                //     saveProfileBtn.html('profile Saved');
                //     location.reload();
                // }else if(res == 1){ //1
                //     saveProfileBtn.html('profile Saved');
                //     location.reload();
                // }else if(res == 2){ //3, 0
                //     saveProfileBtn.html('Save profile');
                //     $('#alertBoxCard').append('<strong>Holy guacamole!</strong> Problem Uploading...!').show();
                // }else if(res == 3){ //0
                //     saveProfileBtn.html('Save profile');
                //     $('#alertBoxCard').append('<strong>Oh Snap!</strong> File size to large or File type is not supported...!').show();
                // }else if(res == 0){
                //     saveProfileBtn.html('Save profile');
                // }else{
                //     location.reload();
                // }
    //         },
    //         error: function (er) {
    //             log(er);
    //         }
    //     });
    // });

    // var saveProfileBtn = g('#saveProfile');
    // saveProfileBtn.click(function(){
    //     alert('hello world');
    // });

    // $('#profileForm').on('submit', function (e) {
    //     e.preventDefault();
    //     saveProfileBtn.html(loaderImg2);
    //     alert(new FormData(this));
        // $.ajax({
        //     url: '/update.profile.php',
        //     type: 'POST',
        //     data: new FormData(this),
        //     contentType: false,
        //     cache: false,
        //     processData: false,
        //     success: function(res){
        //         log(res);
        //         saveProfileBtn.html('save profile');
                // alert(res);
                // if(res == 5){ // 5
                //     saveProfileBtn.html('profile Saved');
                //     location.reload();
                // }else if(res == 1){ //1
                //     saveProfileBtn.html('profile Saved');
                //     location.reload();
                // }else if(res == 2){ //3, 0
                //     saveProfileBtn.html('Save profile');
                //     $('#alertBoxCard').append('<strong>Holy guacamole!</strong> Problem Uploading...!').show();
                // }else if(res == 3){ //0
                //     saveProfileBtn.html('Save profile');
                //     $('#alertBoxCard').append('<strong>Oh Snap!</strong> File size to large or File type is not supported...!').show();
                // }else if(res == 0){
                //     saveProfileBtn.html('Save profile');
                // }else{
                //     location.reload();
                // }
        //     }
        // });
    // });

    $(window).on('scroll', function(e){
        e.preventDefault();
        var scrollTop, winheight, docHeight, n_docHeight, diff;
        diff = 450;
        scrollTop = $(window).scrollTop();
        winheight =  $(window).height();
        docHeight =  $(document).height();
        n_docHeight = docHeight;
        if(((scrollTop + winheight) + diff) >= n_docHeight){$('#loadmoreBtn').click();}
    });
    /*----- end defined built in plugins ---*/
    // $(window).on('load', function(){
        // #################################################
        // # Optional
        // default is PNG but you may also use SVG
        //    emojione.imageType = 'png';
        //    //emojione.sprites = true;
        //    // default is ignore ASCII smileys like :) but you can easily turn them on
        //    emojione.ascii = true;
        //    // if you want to host the images somewhere else
        //    // you can easily change the default paths
        //    emojione.imagePathPNG = urlRoot + 'lib/img/png/';
        //    emojione.imagePathSVG = urlRoot + 'lib/img/svg/';

        // wdtEmojiBundle.defaults.type = 'google';
        // wdtEmojiBundle.defaults.emojiSheets.apple = urlRoot + 'lib/img/sheets/sheet_apple.png';
        // wdtEmojiBundle.defaults.emojiSheets.google = 'lib/img/sheets/sheet_google_64_indexed_128.png';
        // wdtEmojiBundle.defaults.emojiSheets.twitter = urlRoot + 'lib/img/sheets/sheet_twitter.png';
        // wdtEmojiBundle.defaults.emojiSheets.emojione = urlRoot + 'lib/img/sheets/sheet_emojione.png';
        // #################################################

//    var output = wdtEmojiBundle.render('Lorem ipsum :) 🙊');
//         wdtEmojiBundle.defaults.emojiSheets = {
//             'apple': 'https://cdn.rawgit.com/needim/wdt-emoji-bundle/master/sheets/sheet_apple_64.png',
//             'google': 'https://cdn.rawgit.com/needim/wdt-emoji-bundle/master/sheets/sheet_google_64.png',
//             'twitter': 'https://cdn.rawgit.com/needim/wdt-emoji-bundle/master/sheets/sheet_twitter_64.png',
//             'emojione': 'https://cdn.rawgit.com/needim/wdt-emoji-bundle/master/sheets/sheet_emojione_64.png'
//         };
//     });
});
