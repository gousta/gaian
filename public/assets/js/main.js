/* Author:

*/

$(document).ready(function() {

  jQuery('.search-query').typeahead({
    source: function (query, process) {
      $.get('/api/search', { query: query }, function (data) {
        process(data);
      });
    }
  });

  jQuery('.comment .avatar, .ttip').tooltip({
    placement: 'bottom'
  });

  jQuery('textarea').autosize();

  jQuery('.ribbon-login').click(function (e) {
    e.preventDefault();

    var href = jQuery(this).attr('href');

    if (href.indexOf('#') === 0) {
      jQuery('#gaian-panel').slideToggle(250);
    }
  });

  $(function () {
    var a = location.pathname.substring(0);
    $('#globalnav a[href$="' + a + '"]').attr("class", "active")
    $('.navbar li a[href$="' + a + '"]').parent().attr("class", "active")
  });

  // BLOCK CLICK IF ELEEMENT IS DISABLED
  jQuery('.disabled').bind('click', false);

  // MODAL WONDOWS (AJAX LOAD)
  jQuery('[data-toggle="modal"]').click(function (e) {
    e.preventDefault();

    var href = jQuery(this).attr('data-path');

    if (href.indexOf('#') === 0) {
      jQuery(href).modal('open');
    } else {
      $.get(href, function (data) {
        jQuery('<div class="modal fade">' + data + '</div>').modal();
      }).success(function () {
        jQuery('input:text:visible:first').focus();
      });
    }
  });

  $('#artworks-wall .thumbnails').infinitescroll({


    loading: {
      finished: undefined,
      finishedMsg: "<em>Road closed</em>",
      img: "http://www.infinite-scroll.com/loading.gif",
      msg: null,
      msgText: "<em>Loading...</em>",
      selector: null,
      speed: 'fast',
      start: undefined
    },
    state: {
      isDuringAjax: false,
      isInvalidPage: false,
      isDestroyed: false,
      isDone: false,
      isPaused: false,
      currPage: 1
    },
    callback: undefined,
    debug: false,
    behavior: undefined,
    binder: jQuery(window), // used to cache the selector
    nextSelector: "div.navigation a:first",
    navSelector: "div.navigation",
    contentSelector: null, // rename to pageFragment
    extraScrollPx: 150,
    itemSelector: "div.post",
    animate: false,
    pathParse: undefined,
    dataType: 'html',
    appendCallback: true,
    bufferPx: 40,
    errorCallback: function () {},
    infid: 0, //Instance ID
    pixelsFromNavToBottom: undefined,
    path: undefined
  });

});

$(function () {
  $("#add_comment").click(function () {

//    $(this).parent.each(function() {
//      $.find('input, textarea').attr('id').val();
//    });

    var comment = $("#comment_content").val();
    var dataString = 'comment=' + comment;
    
    if (comment == '') {
      log('Comment field is empty');
    } else {
      log('Loading Comment...');
      
      $.ajax({
        type: "POST",
        data: dataString,
        cache: false,
        success: function (html) {
          $(".message span").append(html);

          log('Comment has been sent');
        }
      });
    }
    return false;
  });
});