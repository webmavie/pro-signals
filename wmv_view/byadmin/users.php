<? 
$page='users';
include('_header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Fullname</th>
                            <th>Country</th>
                            <th>Telegram</th>
                            <th>Whatsapp no</th>
                            <th>Email</th>
                            <th>Ip</th>
                            <th>Register date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>№</th>
                            <th>Fullname</th>
                            <th>Country</th>
                            <th>Telegram</th>
                            <th>Whatsapp no</th>
                            <th>Email</th>
                            <th>Ip</th>
                            <th>Register date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $getUsers=$db->get_allrow('users', 'no', 'reg_date', 'DESC');
                            foreach ($getUsers as $key => $user) {
                                echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$user['fullname'].'</td>
                                <td>'.$countries[$user['country']].'</td>
                                <td>'.$user['telegram_username'].'</td>
                                <td>'.$user['whatsapp_no'].'</td>
                                <td>'.$user['email'].' <span class="btn btn-sm bg-'.($user['activated']==1?'success':'danger').'"></span></td>
                                <td>'.$user['ip'].'</td>
                                <td>'.$user['reg_date'].'</td>
                                <td><a href="'.action_url(array('act' => 'delete', 'mode' => 'user', 'id' => $user['id'])).'" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a></td>
                            </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>