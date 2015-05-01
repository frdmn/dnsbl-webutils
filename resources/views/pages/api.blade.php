@extends('layouts.default')
@section('content')
  <h1 class="page-header">API</h1>
  <p>Below you can find a few API calls that you can use to interact and communicate with <strong>dnsbl-webuitls</strong>.</p>

  <h3 class="page-header">Check a hostname/IP for blacklist entries</h3>
  <div>
    <div class="zero-clipboard"><span class="btn-clipboard">Request</span></div>
    <div class="bs-example bs-example-get">
      <pre>/api/v1/check/<mark>[hostname]</mark></pre>
      <h5>Parameter</h5>
      <ul>
        <li><code>hostname</code>: Hostname or IP of the mailserver to check</li>
      </ul>
    </div>
    <div class="zero-clipboard"><span class="btn-clipboard">Response</span></div>
    <div class="highlight">
      <pre>
        <code class="language-javascript">{
  "success": true,
  "information": {
    "execution_time": 4410,
    "dnsbls_total": 233,
    "dnsbls_ok": 229,
    "dnsbls_listed": 4,
    "hostname": "127.0.0.2"
  },
  "payload": [
    {
      "dnsbl": "0spam-killlist.fusionzero.com",
      "result": "DNSBL: not listed",
      "status": 200
    },
    [...]
  ]
}        </code>
      </pre>
    </div>
  </div>

  <h3 class="page-header">Probe a hostname against a specific DNSBL</h3>
  <div>
    <div class="zero-clipboard"><span class="btn-clipboard">Request</span></div>
    <div class="bs-example bs-example-get">
      <pre>/api/v1/probe/<mark>[hostname]</mark>/<mark>[dnsbl]</mark></pre>
      <h5>Parameter</h5>
      <ul>
        <li><code>hostname</code>: Hostname or IP of the mailserver to check</li>
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
