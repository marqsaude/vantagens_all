  jQuery(document).ready(function() {
    
    jQuery('#table2').dataTable({
      "sPaginationType": "full_numbers",
      "oLanguage": {
          "sSearch": "Pesquisar",
          "sLengthMenu": "Quantidade _MENU_ ",
          "sZeroRecords": "Nenhum Registro encontrado",
          "sInfo": "Exibindo de _START_ a _END_ dos _TOTAL_ registros",
          "sInfoEmpty": "Exibindo de 0 a 0 de 0 registros",
          "sInfoFiltered": "(Filtrada a partir de _MAX_ registros totais)",
          "oPaginate": {
              "sFirst": "Primeira",
              "sLast": "Última",
              "sPrevious": "Anterior",
              "sNext": "Próxima"
          }
      }
    });
    
    // Chosen Select
    jQuery("select").chosen({
      'min-width': '100px',
      'white-space': 'nowrap',
      disable_search_threshold: 10
    });
    
    // Delete row in a table
    jQuery('.delete-row').click(function(){
      var c = confirm("Continue delete?");
      if(c)
        jQuery(this).closest('tr').fadeOut(function(){
          jQuery(this).remove();
        });
        
        return false;
    });
    
    // Show aciton upon row hover
    jQuery('.table-hidaction tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1});
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0});
    });

    
  });