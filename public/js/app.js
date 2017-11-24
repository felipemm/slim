;(function() {

  'use strict';

  var app = App.prototype;

  function App(){
    this.init();
  };

  app.init = function () {
    var form = document.querySelectorAll('.js-delete-form');
    for (var prop in form) {
      if ( form.hasOwnProperty(prop) ) {
        if ( "onsubmit" in form[prop] ) {
          form[prop].onsubmit = this.onSubmit;
        }
      }
    }
  };

  app.onSubmit = function () {
    if ( confirm('Deseja mesmo excluir rapá ?') ) {
      return true;
    }
    return false;
  };

  document.addEventListener( 'DOMContentLoaded', new App(), false );

})();