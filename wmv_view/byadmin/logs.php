<? 
$page='logs';
include('_header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Logs</h1>
        
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Delete last from <select id="delete_logs"><option value="7">7 day</option><option value="30">1 month</option><option value="365">1 year</option></select><button class="btn btn-sm btn-danger" onclick="if (confirm('Are you sure?')) { document.location.replace('<?=action_url(array('act' => 'delete', 'mode' => 'logs_actions', 'day' => ''))?>'+$('#delete_logs').val()); }">Delete</button></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>User</th>
                            <th>Page</th>
                            <th>Ip</th>
                            <th>Reg date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $getLogsActions=$db->get_allrow('logs_actions', 'no', 'reg_date', 'DESC');
                            foreach ($getLogsActions as $key => $log) {
                                echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$log['email'].'<sub>('.$log['uid'].')</sub></td>
                                <td>'.$log['page'].'</td>
                                <td>'.$log['ip'].'</td>
                                <td>'.$log['reg_date'].'</td>
                            </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>