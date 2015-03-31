$(document).ready(function() {
  // Hide abort button on page load
  $('.btn-abort-check').hide();

  // Hide results on page load
  $('.results').hide();

  // On click - submit check
  $('.btn-submit-check').on('click', function (e) {
    e.preventDefault();
    $('.alert').hide(); // Hide alert
    $('.btn-abort-check').show(); // Fade in abort button
    $('input#inputMailserver').prop('disabled', true); // Temporary disable input text area
    $('.btn-submit-check').prop('disabled', true); // Temporary disable submit button
    $('.btn-submit-check').text('Checking...'); // Adjust text of submit button
    startBlacklistProbes($('input#inputMailserver').val());
  });

  // Function to start the blacklist probes
  var startBlacklistProbes = function (ipToCheck) {
    $.getJSON('dnsbl.json', function(jsonBlacklists) {
      $('.results tbody').html('');
      $('.results').show(); // Show results table

      var requests = [];
      $.each(jsonBlacklists.blacklists, function(key, value) {
        var promise = $.get('probe.php?dnsbl=' + value + '&ip=' + ipToCheck, function(data, status) {
          if (status === 'success') {
            var jsonProbe = $.parseJSON(data);
            if (jsonProbe.success === true) {
              if (jsonProbe.payload.result === 200) {
                console.log(ipToCheck + ': not listed on "' + jsonProbe.payload.dnsbl + '"');
                $('.results table > tbody').append('<tr><th scope="row">' + key + '</th><td>' + jsonProbe.payload.dnsbl + '</td><td>OK</td></tr>');
              } else if (jsonProbe.payload.result === 300) {
                console.log(ipToCheck + ': listed on "' + jsonProbe.payload.dnsbl + '"');
                $('.results table > tbody').append('<tr><th scope="row">' + key + '</th><td>' + jsonProbe.payload.dnsbl + '</td><td>Not OK!</td></tr>');
              }
            } else {
              console.log('Error: ' + jsonProbe.error);
            }
          }
        });
        requests.push(promise);
      });

      $.when.apply($, requests).done(function() {
        $('.btn-abort-check').hide(); // Hide abort button
        $('input#inputMailserver').prop('disabled', false); // Temporary enable input text area
        $('.btn-submit-check').prop('disabled', false); // Temporary enable submit button
        $('.btn-submit-check').text('Check another'); // Adjust text of submit button
        $('.results table').tablesorter( { sortList: [ [ 2,0 ] ] } );
      });
    });
  }
});
