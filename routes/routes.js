/**
 * Created by Daniel on 7/1/2017.
 */

// 'use strict';
// const app = angular.module("gistInit", ['ngRoute']);
app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider.
        when('/', {
            templateUrl: 'views/components/home-gist-card.html',
            controller: 'mnCntrllr'
        }).
        when('/profile/:username', {
            templateUrl: 'views/components/profile.html',
            controller: 'prflCntrllr',
            reloadOnSearch: false
        }).
        when('/category', {
            templateUrl: 'views/components/category-section.html',
            controller: 'ctgryLstCntrllr'
        }).
        when('/category/:category', {
            templateUrl: 'views/components/cat-gist-view.html',
            controller: 'ctgryGstCntrllr'
        }).
        when('/gist/:id/:gist', {
            templateUrl: 'views/components/gist.html',
            controller: 'gstCntrllr',
            reloadOnSearch: false
        }).
        when('/profile/:username/notification', {
            templateUrl: 'views/components/notification.html',
            controller: 'ntCntrllr'
        }).
        when('/profile/:username/followers', {
            templateUrl: 'views/components/notification-followers.html',
            controller: 'fwrCntrllr'
        }).
        when('/profile/:username/following', {
            templateUrl: 'views/components/notification-following.html',
            controller: 'fwgCntrllr'
        }).
        when('/profile/:username/starred-posts', {
            templateUrl: 'views/components/starred-posts.html',
            controller: 'stpCntrllr'
        }).
        when('/tag/:tag', {
            templateUrl: 'views/components/tag-view.html',
            controller: 'tgCntrllr'
        }).
        when('/search/', {
            templateUrl: 'views/components/search.html',
            controller: 'srchCntrllr'
        }).
        when('/signin', {
            templateUrl: 'views/components/signin.html',
            controller: 'authCntrllr'
        }).
        when('/signup', {
            templateUrl: 'views/components/signup.html',
            controller: 'authCntrllr'
        }).
        when('/signout', {
            templateUrl: 'main.html',
            controller: 'sgnoutCntrllr'
        }).
        when('/terms-of-service', {
            templateUrl: 'views/components/tos.html'
        }).
        when('/recovery', {
            templateUrl: 'views/components/recovery.html',
            controller: 'rcvryCntrllr'
        }).
        when('/birthday', {
            templateUrl: 'views/components/birthdays.html',
            controller: 'brthdyCntrllr'
        }).
        when('/dashboard/report', {
            templateUrl: 'views/components/reports.html',
            controller: 'rprtCntrllr'
        }).
        when('/404', {
            templateUrl: 'views/components/404.html',
            controller: 'fofCntrllr'
        }).
        otherwise({
            redirectTo: '/404'
        });

    if(window.history && window.history.pushState){
        $locationProvider.html5Mode(true); //activate HTML5 Mode
    }
    $locationProvider.hashPrefix('!');
}]);