$(document).ready(function() {
  // Hide abort button on page load
  $('.btn-abort-check').hide();

  // On click - submit check
  $('.btn-submit-check').on('click', function (e) {
    e.preventDefault();
    $('.alert').hide(); // Hide alert
    $('.btn-abort-check').fadeIn(); // Fade in abort button
    $('input#inputMailserver').prop('disabled', true); // Temporary disable input text area
    $('.btn-submit-check').prop('disabled', true); // Temporary disable submit button
    $('.btn-submit-check').text('Checking...'); // Adjust text of submit button
  })
});
