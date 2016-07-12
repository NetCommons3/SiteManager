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
    ['$scope', '$window', function($scope, $window) {

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


/**
 * SiteManager Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $window)} Controller
 */
NetCommonsApp.controller('MembershipInputItems',
    ['$scope', function($scope) {

      /**
       * userAttributes
       *
       * @type {object}
       */
      $scope.userAttributes = [];

      /**
       * initialize
       *
       * @return {void}
       */
      $scope.initialize = function(data) {
        angular.forEach(data.userAttributes, function(value) {
          $scope.userAttributes.push(value);
        });
      };

      /**
       * move
       *
       * @return {void}
       */
      $scope.move = function(type, index) {
        var dest = (type === 'up') ? index - 1 : index + 1;
        if (angular.isUndefined($scope.userAttributes[dest])) {
          return false;
        }

        var destUserAttr = angular.copy($scope.userAttributes[dest]);
        var targetdest = angular.copy($scope.userAttributes[index]);
        $scope.userAttributes[index] = destUserAttr;
        $scope.userAttributes[dest] = targetdest;
      };

      /**
       * desiplay
       *
       * @return {void}
       */
      $scope.display = function(index, value) {
        if (angular.isUndefined($scope.userAttributes[index])) {
          return false;
        }
        $scope.userAttributes[index]['userAttributeSetting']['autoRegistDisplay'] = value;
      };

    }]);


/**
 * SiteManager Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $window)} Controller
 */
NetCommonsApp.controller('WysiwygSiteManager',
    ['$scope', 'NetCommonsWysiwyg', function($scope, NetCommonsWysiwyg) {

      /**
       * tinymce
       *
       * @type {object}
       */
      $scope.tinymce = NetCommonsWysiwyg.new();
      $scope.tinymce.options.toolbar = [
         'fontselect fontsizeselect formatselect ' +
            '| bold italic underline strikethrough ' +
            '| subscript superscript | forecolor backcolor ' +
            '| removeformat ' +
            '| undo redo | alignleft aligncenter alignright ' +
            '| bullist numlist | indent outdent blockquote ' +
            '| table | hr | titleicons | tex | link unlink ' +
            '| pastetext code nc3Preview'
      ];

    }]);
