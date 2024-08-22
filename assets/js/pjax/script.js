$(function(){
   $(document).pjax("a[data-pjax]", "#main");
  
  $(document).on('pjax:complete', function() {
    $('.modal').hide();
  });

  if ($.support.pjax) {
    $(document).on('click', 'a[data-pjax]', function() {
      $('.modal').show();
    })
  }
});