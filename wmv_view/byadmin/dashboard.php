<? 
$page='dashboard';
include('_header.php'); 

$thisday_users=count($db->console("SELECT * FROM {$prefix}_users WHERE date(reg_date) = CURDATE();"));
$total_users=$db->count_row('users');
$thisday_logs=count($db->console("SELECT * FROM {$prefix}_logs WHERE date(reg_date) = CURDATE();"));
$total_impression=getOption('total_impression');

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Home page</h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Reload page</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-3 col-md-12 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Today register</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?=$thisday_users?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-12 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total register</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?=$total_users?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-12 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Today Impressions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?=$thisday_logs?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-12 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">  Total Impressions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_impression?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Guset abouts / Delete last from <select id="delete_logs"><option value="7">7 day</option><option value="30">1 month</option><option value="365">1 year</option></select><button class="btn btn-sm btn-danger" onclick="if (confirm('Are you sure?')) { document.location.replace('<?=action_url(array('act' => 'delete', 'mode' => 'logs', 'day' => ''))?>'+$('#delete_logs').val()); }">Delete</button></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Access date</th>
                                    <th>Continent</th>
                                    <th>Country</th>
                                    <th>İp adress</th>
                                    <th>Times</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>№</th>
                                    <th>Access date</th>
                                    <th>Continent</th>
                                    <th>Country</th>
                                    <th>İp adress</th>
                                    <th>Times</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    $getLogs=$db->get_allrow('logs', 'no', 'reg_date', 'DESC');
                                    foreach ($getLogs as $key => $log) {
                                        echo '<tr>
                                        <td>'.($key+1).'</td>
                                        <td>'.$log['reg_date'].'</td>
                                        <td>'.$log['continent_name'].'</td>
                                        <td>'.$log['country_name'].' <small>('.$log['country_code'].')</small></td>
                                        <td>'.$log['ip'].'</td>
                                        <td>'.$log['times'].'</td>
                                        <td><button class="btn btn-primary" onclick="return load_detail('.$log['id'].');">Detailed</button></td>
                                    </tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function load_detail(id) {
    var action_url = '<?=action_url(array('act' => 'log_detail', 'id' => ''))?>'+id;
    var rows = '';
    $.getJSON(action_url, function(data, status){
        $.each(data,function(key, value){
            rows += "<b>"+key+": <u>"+value+"</u></b><br/>\n";
        });
        $('#detailed_tbody').html(rows);
        $('#detailed').modal();
    });
}
</script>

<div class="modal" id="detailed" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detailed</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detailed_tbody">
          <!-- Body -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- /.container-fluid -->
<? include('_footer.php'); ?>