      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1><?= $settings['title'] ?></h1>
        <p>A DNS-based Blackhole List (<i>DNSBL</i>) or Real-time Blackhole List (<i>RBL</i>) is an effort to stop email spamming. Most mail server software can be configured to reject or flag messages which have been sent from a site listed on one or more such lists.</p>
        <p>Below you can <a class="a-tooltip" href="#" data-toggle="tooltip" data-original-title="Default tooltip">mass test</a> such <i>DNSBL</i>'s against the IPs of your mail servers to possible listings.</p>
      </div><!--/.jumbotron -->

      <div class="alert alert-warning alert-dismissible alert-hint" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Enter the IP address or hostname of your mail server below and hit <strong>Check</strong>.
      </div><!--/.alert -->

      <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%;">
          <span></span>
        </div>
      </div>

      <form class="form-horizontal form-input">
        <div class="form-group">
          <label for="inputMailserverHost" class="col-sm-2 control-label">Mail server</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputMailserverHost" name="inputMailserverHost" placeholder="IP address/hostname">
          </div>
        </div><!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-danger btn-submit-check ladda-button" data-spinner-color="#000000" data-style="expand-left">Check</button>
            <a href="" class="btn btn-danger btn-cancel-check">Cancel</a>
          </div>
        </div><!-- /.form-group -->
      </form><!-- /.form-horizontal -->

      <div class="clearfix"></div>

      <div class="results">
        <hr/>
        <table class="table">
          <thead>
            <tr>
              <th class="col-md-1">#</th>
              <th class="col-md-7">Blacklist</th>
              <th class="col-md-4">Status <span class="label label-danger label-listings"></span></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div><!-- /.results -->
