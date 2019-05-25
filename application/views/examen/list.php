<section class="content">
      <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Examen Medico</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
             </div>
        </div>
        <div class="box-body">
            <?php if ($this->session->userdata('cargo')==1): ?>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="<?php echo base_url(); ?>examen/registrar_cadete" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Cadete</a>
                    </div>
                </div>
                <hr>
            <?php endif ?>
            
            <!-- /.row -->
            <?php if ($this->session->flashdata("success")): ?>
                <script>
                    swal("Exito", "<?php echo $this->session->flashdata("success") ;?>", "success");
                </script>
            <?php endif ?>
            
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo base_url();?>examen/update" method="POST">
                    <table id="tb-without-buttons" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Peso</th>
                                <th>Altura</th>
                                <th>Resultado Test</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php if ($cadetes): ?>
                            
                            <?php foreach ($cadetes as $cadete): ?>
                                <tr>
                                    <td><?php echo $cadete->rut; ?></td>
                                    <td><?php echo $cadete->nombre; ?></td>
                                    <td><?php echo $cadete->fecha_nacimiento; ?></td>
                                    <td><?php echo $cadete->peso; ?></td>
                                    <td><?php echo $cadete->altura; ?></td>
                                    <td><?php echo $cadete->resultado_test; ?></td>
                                    <td>
                                        <?php if ($this->session->userdata("cargo") == 3 || $this->session->userdata("cargo") == 1): ?>
                                            <?php if ($cadete->estado_final !=0): ?>
                                                <?php echo $cadete->estado_final == '1' ? 'APTO':'NO APTO'; ?>
                                            <?php else: ?>
                                                <select name="estados[]" id="estados" required="required" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <option value="1">APTO</option>
                                                    <option value="2">NO APTO</option>
                                                </select>

                                                <input type="hidden" name="cadetes[]" value="<?php echo $cadete->id;?>">
                                            <?php endif ?>
                                        <?php endif ?>

                                        <?php if ($this->session->userdata("cargo") == 5): ?>
                                            <?php if ($cadete->estado_final !=0): ?>
                                                <?php echo $cadete->estado_final == '1' ? 'APTO':'NO APTO'; ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                        
                                    </td>
                                </tr>
                              
                            <?php endforeach;?>
                        <?php endif;?>
                        </tbody>
                    
                        
                    </table>
                    <?php if ($this->session->userdata('cargo')==1): ?>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    <?php endif ?>
                    
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
      <!-- /.box -->
</section>
