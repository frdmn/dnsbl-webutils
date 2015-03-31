$(document).ready(function() {
  /* Functions */

  // Reset progress bar
  function resetProgress(){
    $('.progress-bar').css({ 'width': '0%', 'transition': 'none' });
    $('.progress-bar span').html('');
  }

  function updateProgress(current, max){
    // Calculate percent
    var percent = 100 / max * current;
    // Adjust width
    $('.progress-bar').css('width', Math.round(percent) + '%');
    $('.progress-bar span').html(current + ' / ' + max);
  }

  function countTableRows(){
    // Return the current amount of rows in our result table
    return $('.results tbody tr').length;
  }

  // Enable general inputs
  function enableInputs(){
    $('.spinner').hide();
    $('.results').hide();
    $('.btn-cancel-check').hide();
    $('input#inputMailserverHost').prop('disabled', false);
    $('.btn-submit-check').prop('disabled', false);
  }

  // Disable general inputs
  function disableInputs(){
    $('.spinner').fadeIn();
    $('.results').show();
    $('.btn-cancel-check').show();
    $('input#inputMailserverHost').prop('disabled', true);
    $('.btn-submit-check').prop('disabled', true);
  }

  // Enable inputs on page load
  enableInputs();

  // Initialize table sorter
  $('.results table').tablesorter();

  // Function to start the blacklist probes
  var startBlacklistProbes = function (hostToCheck, obj) {
    $('.results tbody').html('');
    resetProgress();
    $('.results').show(); // Show results table

    var requests = [];
    $.each(obj.blacklists, function(key, value) {
      var promise = $.get('api/?dnsbl=' + value + '&host=' + hostToCheck, function(data, status) {
        if (status === 'success') {
          var jsonProbe = $.parseJSON(data);
          if (jsonProbe.success === true) {
            if (jsonProbe.payload.result === 200) {
              console.log(hostToCheck + ': not listed on "' + jsonProbe.payload.dnsbl + '"');
              $('.results table > tbody').append('<tr><th scope="row">' + key + '</th><td>' + jsonProbe.payload.dnsbl + '</td><td>OK</td></tr>');
            } else if (jsonProbe.payload.result === 300) {
              console.log(hostToCheck + ': listed on "' + jsonProbe.payload.dnsbl + '"');
              $('.results table > tbody').append('<tr><th scope="row">' + key + '</th><td>' + jsonProbe.payload.dnsbl + '</td><td class="bg-danger">Not OK!</td></tr>');
            }
          } else {
            console.log('Error: ' + jsonProbe.error);
            $('.results table > tbody').append('<tr><th scope="row">' + key + '</th><td>' + value + '</td><td class="bg-danger">Error: ' + jsonProbe.error + '</td></tr>');
          }
          updateProgress(countTableRows(), obj.blacklists.length);
        }
      });

      $('.btn-cancel-check').on('click', function(e) {
        e.preventDefault();
        promise.abort();
        /* jshint ignore:start */
        delete requests;
        /* jshint ignore:end */
        resetProgress();
        enableInputs()
      });

      requests.push(promise);
    });

    // Enable stuff again, when all API calls are finished
    $.when.apply($, requests).done(function() {
      enableInputs();
      $('.results').show();
      $('.btn-submit-check').text('Check another'); // Adjust text of submit button
      $('.results table').trigger('update')
        .trigger('appendCache')
        .trigger('sorton',[ [ [ 2,0 ] ] ]); // Sort table
    });
  }

  // Show RBL count in jumbotron
  $.getJSON('dnsbl.json', function(json) {
    var jsonObj = json;
    $('.a-tooltip').attr('data-original-title', 'Currently testing agaist ' + jsonObj.blacklists.length + ' RBLs.').tooltip();

    // Validate input form
    $('form.form-input').formValidation({
      framework: 'bootstrap'
      , icon: {
        valid: 'glyphicon glyphicon-ok'
        , invalid: 'glyphicon glyphicon-remove'
        , validating: 'glyphicon glyphicon-refresh'
      }
      , fields: {
        inputMailserverHost: {
          validators: {
            notEmpty: {
              message: 'The full name is required'
            }
          }
        }
      }
    }).on('success.form.fv', function(e) {
      // Prevent form submission
      e.preventDefault();

      // // instances, we can use at a later point
      // var $form = $(e.target) // The form instance
      // , fv    = $(e.target).data('formValidation'); // FormValidation instance
      disableInputs();
      $('.alert-hint').hide(); // Hide hint
      $('.btn-submit-check').text('Checking...'); // Adjust text of submit button
      startBlacklistProbes($('input#inputMailserverHost').val(), jsonObj);
    });
  });
});
