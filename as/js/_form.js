$(document).ready(function(){

   $('.alph').alpha({allow:".,-' "});
   $('.uspw').alphanumeric({nocaps:true});
   $('.num').numeric({allow:'.'});
   $('.alphnum').alphanumeric({allow:'- '});
   $('.telp').numeric({allow:'-()+'});

   $('.rupiah')
      .autoNumeric('init')
      .on('blur', function(e) {
         $('#form_input').formValidation('revalidateField','total');
   });

   $('.tgl')
      .datepicker({format: 'dd-mm-yyyy', autoclose: true, language: 'id'})
      .on('changeDate', function(e) {
         $('#form_input').formValidation('revalidateField','tanggal');
         $('#form_input').formValidation('revalidateField','tanggal_lahir');
   });

   $('.editor-mini').summernote({
      toolbar: [
         ['style', ['']], // no style button
         ['style', ['bold', 'italic', 'underline', '']],
         ['fontsize', ['']],
         ['color', ['']],
         ['para', ['ul', 'ol', '']],
         ['height', ['']],
         ['insert', ['','','','']], // no insert buttons
         ['table', ['','','']], // no table button
         ['help', ['','','','','']] //no help button
      ]
   });

   $('.editor').summernote({
      toolbar: [
         ['style', ['style']], // no style button
         ['style', ['bold', 'italic', 'underline', '']],
         ['fontsize', ['']],
         ['color', ['']],
         ['para', ['ul', 'ol', 'paragraph']],
         ['height', ['']],
         ['insert', ['','','','']], // no insert buttons
         ['table', ['','','']], // no table button
         ['help', ['','','','','']] //no help button
      ]
   });

   $('[data-name="help"]').remove();

   $('.editor-full').summernote();

   $('.btn-aksi').click(function(e) {
      e.preventDefault();
      load_halaman_modal($(this).attr('href'));
   });

   function load_halaman_modal(url) {
      $("#load-animasi").fadeIn(200);

      setTimeout(function(){
         $("#modal-layout").load(url, function(){
            $("#load-animasi").fadeOut(300);
            $("#modal-layout").modal("show");
         });
      },400);
   }

   $('.btn-progress').click(function() {
      $('#load-animasi').fadeIn(200);
   });

   $('.hx_form_upload_file')
        .on('init.field.fv', function(e, data) {
            var $parent = data.element.parents('.form-group'),
                $icon   = data.element.data('fv.icon'),
                $label  = $parent.find('label');
            $icon.insertAfter($label);
        })
        .formValidation({
            framework: 'bootstrap',
            icon: {
               valid: 'fa fa-check-circle',
               invalid: 'fa fa-warning',
               validating: 'fa fa-spinner'
            },
            exclude: ':disabled',
            locale: 'id_ID'
        })
        .on('success.form.fv', function(e) {
            $("#load-animasi").fadeIn(200);
        });

   $('#form_input')
        .on('init.field.fv', function(e, data) {
            var $parent = data.element.parents('.form-group'),
                $icon   = data.element.data('fv.icon'),
                $label  = $parent.find('label');
            $icon.insertAfter($label);
        })
        .formValidation({
            framework: 'bootstrap',
            icon: {
               valid: 'fa fa-check-circle',
               invalid: 'fa fa-warning',
               validating: 'fa fa-spinner'
            },
            exclude: ':disabled',
            locale: 'id_ID'
        })
        .on('success.form.fv', function(e) {
            $("#load-animasi").fadeIn(200);
        });
});