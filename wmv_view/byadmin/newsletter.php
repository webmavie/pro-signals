<? 
$page='newsletter';
include('_header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Newsletter users</h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Newsletter users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Ip</th>
                            <th>Register date</th>
                            <th>№</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Email</th>
                            <th>Ip</th>
                            <th>Register date</th>
                            <th>№</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $getNewsletter=$db->get_allrow('newsletter', 'no', 'reg_date', 'DESC');
                            foreach ($getNewsletter as $key => $newsletter) {
                                echo '<tr>
                                <td>'.$newsletter['email'].'</td>
                                <td>'.$newsletter['ip'].'</td>
                                <td>'.$newsletter['reg_date'].'</td>
                                <td>'.($key+1).'</td>
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