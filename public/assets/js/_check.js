/* global SpinSubmit */

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
    $('.progress-bar span').html('RBL check ' + current + ' / ' + max);
  }

  function countTableRows(){
    // Return the current amount of rows in our result table
    return $('.results tbody tr').length;
  }

  function updateListingBadge(){
    /* jshint ignore:start */

    // Count listings and errors
    var listings = $(".results tbody tr:contains('Listed')").length
    , errors = $(".results tbody tr:contains('Error')").length;

    // If no listing, add success class, otherwise remove it
    if (listings == 0) {
      $('.label-listings').removeClass('label-danger');
      $('.label-listings').addClass('label-success');
    } else {
      $('.label-listings').removeClass('label-success');
      $('.label-listings').addClass('label-danger');
    }

    // Show possible error label
    if (errors > 0) {
      $('.label-errors').show();
      $('.label-errors').html(errors + ' errors');
    } else {
      $('.label-errors').hide();
      $('.label-errors').html('');
    }

    // Update listings label
    $('.label-listings').html(listings + ' listings');

    /* jshint ignore:end */
  }

  // Enable general inputs
  function enableInputs(){
    $('.results').hide();
    $('.btn-cancel-check').hide();
    $('input#inputMailserverHost').prop('disabled', false);
    $('.btn-submit-check').prop('disabled', false);
  }

  // Disable general inputs
  function disableInputs(){
    $('.results').show();
    $('.btn-cancel-check').show();
    $('input#inputMailserverHost').prop('disabled', true);
    $('.btn-submit-check').prop('disabled', true);
  }

  /*init*/
  var spinnerInput = $('#spinner')
  , Spinner = new SpinSubmit(spinnerInput);

  // Enable inputs on page load
  enableInputs();

  // Hide progress bar
  $('.progress').addClass('progress--hidden');

  // Initialize table sorter
  $('.results table').tablesorter();

  // Function to start the blacklist probes
  var startBlacklistProbes = function (hostToCheck, obj) {
    $('.results tbody').html('');
    resetProgress();
    $('.progress').removeClass('progress--hidden');
    $('.results').show();

    var requests = [];
    $.each(obj.blacklists, function(key, value) {
      var rowId = parseFloat(key) + parseFloat(1)
      , promise = $.get('/api/v1/probe/' + hostToCheck + '/' + value, function(data, status) {
        if (status === 'success') {
          if (data.success === true) {
            console.log((key + 1) + '/' + obj.blacklists.length + ': ' +  hostToCheck + ' on "' + data.payload.dnsbl + '"');
            if (data.payload.status === 200) {
              console.log('==> ' + '%cnot listed', 'background: forestgreen; color: #fff');
              $('.results table > tbody').append('<tr><th scope="row">' + rowId + '</th><td>' + data.payload.dnsbl + '</td><td>OK</td></tr>');
            } else if (data.payload.status === 300) {
              console.log('==> ' + '%clisted', 'background: tomato; color: #fff');
              $('.results table > tbody').append('<tr><th scope="row">' + rowId + '</th><td>' + data.payload.dnsbl + '</td><td class="bg-danger">Listed</td></tr>');
            }
          } else {
            console.log('==> ' + '%cerror: ' + data.payload.status + ': ' + data.payload.result, 'background: tomato; color: #fff');
            $('.results table > tbody').append('<tr><th scope="row">' + rowId + '</th><td>' + value + '</td><td class="bg-danger">Error: ' + data.payload.result + '</td></tr>');
          }
          updateProgress(countTableRows(), obj.blacklists.length);
          updateListingBadge();
        }
      });

      $('.btn-cancel-check').on('click', function(e) {
        e.preventDefault();
        promise.abort();
        /* jshint ignore:start */
        delete requests;
        /* jshint ignore:end */
        resetProgress();
        enableInputs();
        Spinner.stop('Check another');
      });

      requests.push(promise);
    });

    // Enable stuff again, when all API calls are finished
    $.when.apply($, requests).done(function() {
      enableInputs();
      $('.results').show();
      $('.progress').addClass('progress--hidden');
      $('.results table').trigger('update')
        .trigger('appendCache')
        .trigger('sorton',[ [ [ 2,0 ], [ 0,0 ] ] ]); // Sort table
      Spinner.stop('Check another');
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

      Spinner.start('Checking...');

      // // instances, we can use at a later point
      // var $form = $(e.target) // The form instance
      // , fv    = $(e.target).data('formValidation'); // FormValidation instance

      // Disable inputs during the check
      disableInputs();
      // As well as prepare some other elements
      $('.alert-hint').hide();
      startBlacklistProbes($('input#inputMailserverHost').val(), jsonObj);
    });
  });
});
