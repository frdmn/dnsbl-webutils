@extends('layouts.default')
@section('content')
  <h1 class="page-header">API</h1>
  <p>Below you can find a few API calls that you can use to interact and communicate with <strong>dnsbl-webuitls</strong>.</p>

  <h3 class="page-header">Check a hostname against one specific DNSBL <small>(Work in progress!)</small></h3>
  <div>
    <div class="zero-clipboard"><span class="btn-clipboard">Request</span></div>
    <div class="bs-example bs-example-get">
      <pre>/api/v1/check?<strong>host</strong>=<mark>[hostname.tld]</mark>&<strong>dnsbl</strong>=<mark>[dnsbl.host.tld]</mark></pre>
      <h5>Parameter</h5>
      <ul>
        <li><code>host</code>: Hostname or IP of the mailserver to check</li>
        <li><code>dnsbl</code>: Hostname or IP of the DNSBL server</li>
      </ul>
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
