/**
 * Created by Daniel on 7/1/2017.
 */
function encodeGistPermalink(title) {
    // title = title.replace(/\s+/g, '-');
    title = title.split(' ').join('-');
    return title;
}

app.filter('limitCharacters',function(){
    return function(input,characterCount){
        return (input.length > characterCount) ? input.substring(0,characterCount) : input;
    }
});

app.filter('permalink',function(){
    return function(title){
        return title===undefined ? '' : angular.lowercase(title).replace(/[\s]/g,'-');
    }
});

app.filter('undoPermalink',function(){
    return function(title){
        return title===undefined ? '' : angular.lowercase(title).replace(/-/g, ' ');
    }
});

app.filter('keywordise',function(){
    return function(title){
        return title===undefined ? '' : angular.lowercase(title).replace(/[\s]/g,', ');
    }
});

app.filter('escape', function() {
    return function(input) {
        if(input) {
            return window.encodeURIComponent(input);
        }
        return '';
    }
});