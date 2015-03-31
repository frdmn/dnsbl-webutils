$(document).ready(function() {
  // Hide progress bar on page load
  $('.progress').hide();

  // Hide abort button on page load
  $('.btn-abort-check').hide();

  // On click - submit check
  $('.btn-submit-check').on('click', function (e) {
    e.preventDefault();
    $('.alert').hide(); // Hide alert
    $('.progress').fadeIn(); // Fade in progress bar
    $('.btn-abort-check').fadeIn(); // Fade in progress bar
    $('.btn-submit-check').prop('disabled', true); // Disable submit button
    $('.btn-submit-check').text('Checking...'); // Adjust text of submit button
  })
});
