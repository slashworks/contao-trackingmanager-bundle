!(function ($) {

  var trackingmanager = {

    /**
     *
     */
    init: function(){

      this.setEvents()
      this.toggleForm()

      $('.trackingmanager').addClass('ready')

      //toggle description
      $('.info').on('click',function(e){
        e.preventDefault(e)
        $(this).next().toggle('fast');
      });

    },

    /**
     *
     */
    toggleForm: function(){

      var toggler = $('#tm_more');
      toggler.on('click',function(e){
        e.preventDefault(e)
        $('#trackingmanager').toggle();
      })

    },

    /**
     *
     */
    setEvents: function () {


      $('.tm_submit_all').on('click',function(e){
        e.preventDefault();

        $('.tm_chkbx').each(function (index, el) {
          setCookie($(el).attr('id'), $(el).attr('value'),dateString)
        })

        location.reload();

      })
      /**
       *
       */
      $('#trackingmanager').on('submit', function (e) {
        e.preventDefault(e)

        $('.tm_chkbx').each(function (index, el) {
          if ($(el).is(':checked')) {
            setCookie($(el).attr('id'), $(el).attr('value'),dateString)
          }
          else {
            deleteCookie($(el).attr('id'))
          }
        })
        location.reload();
      });

      /**
       *
       */
      $('#tm_denied').on('click',function(e){
        e.preventDefault(e)
        $('.trackingmanager').removeClass('ready');
      })


    }


  }


  /**
   * date
   */
  var date = new Date();
  date.setDate(date.getDate() + 30);
  var dateString = date.toUTCString();


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



  $('document').ready(function () {
    trackingmanager.init();
  })

})(jQuery)


