$(function() {
  $(document).on('change', '.form', function() {
    if($(this).val()) {
      $('.btn-restore').attr('disabled', false);
      $('.btn-clear-select').attr('hidden', false);
    } else {
      $('.btn-restore').attr('disabled', true);
      $('.btn-clear-select').attr('hidden', true);
    }
  });
  
  $(document).on('click', '.btn-clear-select', function() {
    $(this).attr('hidden', true);
    $('.btn-restore').attr('disabled', true);
  });
});