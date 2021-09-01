<? 
$page='faq';
include('_header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">FAQ </h1>
        
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?=base_url('byadmin/add_faq')?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add new</a></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable2" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Language</th>
                            <th>Title</th>
                            <th>Text</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>№</th>
                            <th>Language</th>
                            <th>Title</th>
                            <th>Text</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $getFaq=$db->get_allrow('faq', 'no', 'order', 'ASC');
                            foreach ($getFaq as $key => $faq) {
                                echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$code_to_lang[$faq['lang_code']].'</td>
                                <td>'.$faq['title'].'</td>
                                <td>'.$faq['text'].'</td>
                                <td><a href="'.base_url('byadmin/edit_faq?id='.$faq['id']).'" class="btn btn-sm btn-primary">Edit</a><a href="'.action_url(array('act' => 'delete', 'mode' => 'faq', 'id' => $faq['id'])).'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a></td>
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