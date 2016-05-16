/**
 * @fileoverview SiteManager Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * SiteManager Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $window)} Controller
 */
NetCommonsApp.controller('SiteManager',
    ['$scope', '$window', '$location', function($scope, $window, $location) {

      /**
       * 入会退会URL
       */
      $scope.membershipUrl = null;

      /**
       * 入会退会タブ
       */
      $scope.membershipTab = null;

      /**
       * 入会退会のinitialize
       *
       * @return {void}
       */
      $scope.membershipInit = function(url, tab) {
        $scope.membershipUrl = url;
        $scope.membershipTab = tab;
      };

      /**
       * キャンセル
       *
       * @return {void}
       */
      $scope.membershipCancel = function() {
        var url = $scope.baseUrl + $scope.membershipUrl + $scope.membershipTab;
        if ($window.location.href === url) {
          $window.location.reload();
        } else {
          $window.location.href = $scope.baseUrl + $scope.membershipUrl + $scope.membershipTab;
        }
      };

      /**
       * Radio click
       *
       * @return {void}
       */
      $scope.click = function($event) {
        return Number($event.target.value);
      };

      /**
       * キャンセル
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $window.location.reload();
      };

    }]);
