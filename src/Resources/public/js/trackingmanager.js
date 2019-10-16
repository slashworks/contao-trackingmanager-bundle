!(function ($) {

  var trackingmanager = {

    init: function(){
      $('.info').on('click',function(){
        $(this).next().toggle('slow');
      })
    }
  }



  $('document').ready(function () {

    /**
     * init
     *
     */
    $('.trackingmanager').addClass('ready')
    var $form = $('#trackingmanager')

    //toggle description
    $('.info').on('click',function(){
      $(this).next().toggle('fast');
    })

    /**
     * date
     */
    var date = new Date();
    date.setDate(date.getDate() + 30);
    var dateString = date.toUTCString();


    /**
     *
     */
    $form.on('submit', function (e) {
      e.preventDefault(e)

      $('.tm_chkbx').each(function (index, el) {
        if ($(el).is(':checked')) {
          setCookie($(el).attr('id'), $(el).attr('value'),dateString)
        }
        else {
          deleteCookie($(el).attr('id'))
        }
      })

      //$('.trackingmanager').removeClass('ready')
      location.reload();
    })

    /**
     *
     * @param name
     * @param value
     * @param expires
     */
    var setCookie = function (name, value, expires) {
      document.cookie = name + '=' + value +'; expires=' + expires;
    }

    /**
     *
     * @param name
     */
    var deleteCookie = function (name) {
      document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC;'

    }

  })

})(jQuery)


