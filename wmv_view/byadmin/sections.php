<? 
$page='sections';
include('_header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sections </h1>
        
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><!--<a href="<?=base_url('byadmin/sections')?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add new</a>--></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable2" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Language</th>
                            <th>Position</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <tr>
                            <th>№</th>
                            <th>Language</th>
                            <th>Position</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $getSections=$db->get_allrow('sections', 'no', 'reg_date', 'DESC');
                            foreach ($getSections as $key => $sections) {
                                echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$code_to_lang[$sections['lang_code']].'</td>
                                <td>'.$sections['position'].'</td>
                                <td>'.$sections['title'].'</td>
                                <td>'.($sections['status']==1?'<u class="text-success">enabled</u>':'<u class="text-danger">disabled</u>').'</td>
                                <td><a href="'.base_url('byadmin/edit_sections?id='.$sections['id']).'" class="btn btn-sm btn-primary">Edit</a></td>
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