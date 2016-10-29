$(document).ready(function(){

   //$('.btn').tooltip({ placement:'top',container:'body' });
   $('.tip').tooltip({ placement:'top',container:'body' });
   $('.tipb').tooltip({ placement:'bottom',container:'body' });
   $('.form-control').tooltip({ placement:'top',container:'body' });
   $('.fa').tooltip({ placement:'top',container:'body' });

   $('.pop').popover({ placement:'right',container:'body',trigger:'hover' });

   setTimeout(function() {
      $('.alert').fadeOut('slow',function() {
         $('.alert').alert('close');
      });
   }, 10000);                                                                   
});