@extends('layouts.default')
@section('content')
  <h1 class="page-header">API</h1>
  <p>Below you can find a few API calls that you can use to interact and communicate with <strong>dnsbl-webuitls</strong>.</p>

  <h3 class="page-header">Check a hostname against a DNSBL <small>(Work in progress!)</small></h3>
  <div>
    <div class="zero-clipboard"><span class="btn-clipboard">Request</span></div>
    <div class="bs-example bs-example-get">
      <pre>/api/v1/check?host=<strong>[hostname.tld]</strong>&dnsbl=<strong>[dnsbl.host.tld]</strong></pre>
      <dl class="dl-horizontal">
        <dt><code>host</code></dt><dd>Hostname or IP of the mailserver to check</dd>
        <dt><code>dnsbl</code></dt><dd>Hostname or IP of the DNSBL server</dd>
      </dl>
    </div>
    <div class="zero-clipboard"><span class="btn-clipboard">Response</span></div>
    <div class="highlight">
      <pre>
        <code class="language-javascript">{
  payload: {
    host: "127.0.0.2",
    dnsbl: "access.redhawk.org",
    result: "DNSBL: listed",
    status: 300
  },
  success: true
}        </code>
      </pre>
    </div>
  </div>

  <div class="clearfix"></div>
@stop
