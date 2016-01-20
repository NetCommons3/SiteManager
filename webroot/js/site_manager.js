/**
 * @fileoverview SiteManager Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * SiteManager Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('SiteManager', function($scope) {

  /**
   * Radio click
   *
   * @return {void}
   */
  $scope.click = function($event, domId) {
    if (domId) {
      $('#' + domId).checked = true;
    }
    return Number($event.target.value);
  };

});
