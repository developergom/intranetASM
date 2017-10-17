var
    total_gross = 0,
    total_disc = 0,
    total_nett = 0,
    total_omzet = 0,
    tpl = ['No', 'Type', 'Media', 'Edition/Period Start', 'Period End', 'Rate Name', 'Insertion', 'Gross Rate', 'Disc(%)', 'Nett Rate', 'Cost Pro', 'Internal Turnover', 'Remarks'],
    data = [     
    ],
    container = document.getElementById('example'),
    hot1;

  hot1 = new Handsontable(container, {
    startRows: 1,
    height: 200,
    minSpareRows: 1,
    formulas:true,
    contextMenu: ['row_above', 'row_below', 'col_left', 'col_right', 'remove_row', 'remove_col', 'undo', 'redo', 'alignment', 'copy', 'cut'],
    colHeaders: ['No', 'Type', 'Rate Name', 'Media', 'Edition/Period Start', 'Period End', 'Omzet Type', 'Insertion', 'Gross Rate', 'Disc(%)', 'Nett Rate', 'Internal Omzet', 'Remarks', 'Termin', 'Status', 'Edited', 'Halaman', 'Kanal', 'Order Digital', 'Materi', 'Status Materi', 'Capture Materi', 'Sales Order', 'PO-Perjanjian', 'PPN', 'Total'],
    columns: [
      {type: 'numeric'}, //no
      {//type
            type: 'autocomplete',
            source: [
                    'cost_pro',
                    'media_cost',
                    ],
            strict: true
      },
      {//rate name
        type: 'autocomplete',
        source: function (query, process) {
                  $.ajax({
                    url: base_url + 'master/rate/api/all',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        query: query
                    },
                    success: function (response) {
                      process(response);

                    }
                  });
                },
        strict: true,
        visibleRows: 5,
        trimDropdown: false
      },
      {//media
      	type: 'autocomplete',
        source: function (query, process) {
                  $.ajax({
                    url: base_url + 'master/media/api/all',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        query: query
                    },
                    success: function (response) {
                      process(response);

                    }
                  });
                },
        strict: true,
        visibleRows: 5
      },
      {//period start
        type: 'date'
      },
      {//period end
        type: 'date'
      },
      {//omzet type
        type: 'autocomplete',
        source: function (query, process) {
                  $.ajax({
                    url: base_url + 'master/omzettype/api/all',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        query: query
                    },
                    success: function (response) {
                      process(response);

                    }
                  });
                },
        strict: true,
        visibleRows: 5
      },
      {//insertion
        type: 'numeric'
      },
      {//gross
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      },
      {//disc
        type: 'numeric'
      },
      {//nett
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      },
      {//omzet internal
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      },
      {},
      {type: 'numeric'}, //termin
      {//status tayang
        type: 'autocomplete',
        source: [
                'COMPLETED',
                'PROCESS',
                'TBC',
                'CONFIRMED'
                ],
        strict: true
      },
      {
        //editable
        type: 'autocomplete',
        source: [
                'NO',
                'YES'
        ]
      },
      {},
      {},
      {},
      {},
      {},
      {},
      {},
      {},
      {//ppn
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      },
      {//total
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      }
    ],
    hiddenColumns: {
      columns: [16, 17, 18, 19, 20, 21, 22, 23, 24, 25],
      indicators: true
    },
    afterChange: function(changes) {
        if(changes!==null){
            var instance = this,
                ilen = changes.length,
                dataRef;

            dataRef = instance.getData();

            //console.log(changes);
            //console.log(dataRef);
            
            for(i = 0;i < ilen; i++){
                //get rate data
                if(changes[i][1]=='2')
                {
                  var loop_index = i;
                  var rate_name = dataRef[changes[i][0]][2];
                  var media_name = '';
                  var gross_rate = 0;
                  
                  $.ajax({
                      url: base_url + 'master/rate/api/name',
                      dataType: 'json',
                      method: 'POST',
                      data: {
                          _token: $('meta[name="csrf-token"]').attr('content'),
                          rate_name: rate_name
                      },
                      success: function (response) {
                        media_name = response.media.media_name;
                        gross_rate = response.gross_rate;

                        instance.setDataAtCell(changes[loop_index][0],3,media_name);
                        //instance.setDataAtCell(changes[loop_index][0],7,1);
                        instance.setDataAtCell(changes[loop_index][0],8,gross_rate);
                      }
                  });
                }

                //on change insertion
                if(changes[i][1]=='7')
                {
                  var gross_rate = dataRef[changes[i][0]][7] * dataRef[changes[i][0]][8];
                  this.setDataAtCell(changes[i][0],8,gross_rate);
                }

                //count nett rate
                if(changes[i][1]=='8' || changes[i][1]== '10')
                {
                    //var result = dataRef[changes[i][0]][8] - (dataRef[changes[i][0]][8] * dataRef[changes[i][0]][9] / 100);
                    var discount = Math.ceil(((dataRef[changes[i][0]][8] - dataRef[changes[i][0]][10]) / dataRef[changes[i][0]][8]) * 100);
                    //console.log(result);
                    this.setDataAtCell(changes[i][0],9,discount);
                    //this.setDataAtCell(changes[i][0],11,dataRef[changes[i][0]][10]);

                    calculateTotal(this);
                }

                //count omzet
                if(changes[i][1]=='11')
                {
                  calculateOmzet(this);
                }
            }

            $.ajax({
              url: base_url + 'workorder/summary/api/saveDetails',
              dataType: 'json',
              method: 'POST',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  details: dataRef
              },
              success: function (response) {

              }
            });
        }
    },
    afterRemoveRow: function(index, amount) {
      calculateTotal(this);
      calculateOmzet(this);
    }
  });


$(document).ready(function(){
  
  $.ajax({
    url: base_url + 'workorder/summary/api/loadDetails',
    dataType: 'json',
    method: 'GET',
    success: function (response) {
      var data = response;

      hot1.loadData(data);
      calculateTotal(hot1);
      calculateOmzet(hot1);

      hot1.updateSettings({
         cells: function(row, col, prop){
          var cellProperties = {};
            /*if(hot1.getDataAtCell(row, 14) === 'COMPLETED'){
              cellProperties.readOnly = 'true'
            }*/
            cellProperties.readOnly = 'true';
          return cellProperties
        }
      });
    }
  });

  //btn preview click function
  $('#btn-preview').click(function(){
    preview_summary(hot1);
  });

  //btn recalculate click function
  $('#btn-recalculate').click(function(){
    recalculate(hot1);
  });

  //toggle edit
  $('#edit-items').change(function(){
    if($(this).prop('checked')){
      hot1.updateSettings({
         cells: function(row, col, prop){
          var cellProperties = {};
            if(hot1.getDataAtCell(row, 14) !== 'COMPLETED'){
              cellProperties.readOnly = false
            }else{
              cellProperties.readOnly = true
            }
          return cellProperties
        }
      });
    }else{
      hot1.updateSettings({
         cells: function(row, col, prop){
          var cellProperties = {};
            cellProperties.readOnly = 'true';
          return cellProperties
        }
      });
    }
  });
});

  //hot1.loadData(data);

  function calculateTotal(hot)
  {
    var data = hot.getData();
    total_gross = 0;
    total_nett = 0;
    for(x=0;x<data.length;x++)
    {
      var nett = data[x][8] - (data[x][8] * data[x][9] / 100);
      total_gross += data[x][8];
      total_nett += data[x][10];
    }
    
    total_disc = Math.ceil((total_gross - total_nett) / total_gross * 100);
    
    $('#summary_total_gross').val(total_gross);
    $('#summary_total_discount').val(total_disc);
    $('#summary_total_nett').val(total_nett);

    $('#summary_total_media_cost').val(calculatePerType(hot, 'media_cost'));
    $('#summary_total_cost_pro').val(calculatePerType(hot, 'cost_pro'));

    $('#format_summary_total_gross').val(previewMoney(total_gross));
    $('#format_summary_total_disc').val(total_disc);
    $('#format_summary_total_nett').val(previewMoney(total_nett));

    $('#format_summary_total_media_cost').val(previewMoney(calculatePerType(hot, 'media_cost')));
    $('#format_summary_total_cost_pro').val(previewMoney(calculatePerType(hot, 'cost_pro')));    
  }

  function calculateOmzet(hot)
  {
    var data = hot.getData();
    total_omzet = 0;

    for(x=0;x<data.length;x++)
    {
      total_omzet += data[x][11];
    }
    
    $('#summary_total_internal_omzet').val(total_omzet);
    $('#format_summary_total_internal_omzet').val(previewMoney(total_omzet));
  } 

  function calculatePerType(hot, type)
  {
    var data = hot.getData();
    var totalType = 0;

    for(x = 0; x < data.length; x++)
    {
      if(data[x][1]==type)
      {
        totalType += data[x][10];
      }
    }

    return totalType;
  }

  function preview_summary(hot)
  {
    var preview_term_of_payment = '';
    var preview_total_gross = '';
    var preview_total_internal_omzet = '';
    var preview_total_disc = '';
    var preview_total_media_cost = '';
    var preview_total_nett = '';
    var preview_total_cost_pro = '';
    var preview_notes = '';

    var preview_details_data = hot.getData();
    var html = '';
    $.each(preview_details_data, function(key, value){
      if(value[0]!=null) {
        html += '<tr>';
        html += '<td>' + value[0] + '</td>';
        html += '<td>' + value[1] + '</td>';
        html += '<td>' + value[2] + '</td>';
        html += '<td>' + value[3] + '</td>';
        html += '<td>' + value[4] + '</td>';
        html += '<td>' + value[5] + '</td>';
        html += '<td>' + value[6] + '</td>';
        html += '<td>' + value[7] + '</td>';
        html += '<td>' + value[8] + '</td>';
        html += '<td>' + value[9] + '</td>';
        html += '<td>' + value[10] + '</td>';
        html += '<td>' + value[11] + '</td>';
        html += '<td>' + value[12] + '</td>';
        html += '<td>' + value[13] + '</td>';
        html += '<td>' + value[14] + '</td>';
        html += '<td>' + value[15] + '</td>';
        html += '<td>' + value[16] + '</td>';
        html += '<td>' + value[17] + '</td>';
        html += '<td>' + value[18] + '</td>';
        html += '<td>' + value[19] + '</td>';
        html += '<td>' + value[20] + '</td>';
        html += '<td>' + value[21] + '</td>';
        html += '<td>' + value[22] + '</td>';
        html += '<td>' + value[23] + '</td>';
        html += '<td>' + value[24] + '</td>';
        html += '</tr>';
      }
    });

    $('#preview_details_table tbody').empty().append(html);    

    preview_term_of_payment = $('input[name="top_type"]:checked').val();
    preview_total_gross = $('#format_summary_total_gross').val();
    preview_total_internal_omzet = $('#format_summary_total_internal_omzet').val();
    preview_total_disc = $('#format_summary_total_disc').val();
    preview_total_media_cost = $('#format_summary_total_media_cost').val();
    preview_total_nett = $('#format_summary_total_nett').val();
    preview_total_cost_pro = $('#format_summary_total_cost_pro').val();
    tinyMCE.triggerSave();
    preview_notes = $('#summary_notes').val();

    $('#preview_term_of_payment').empty().append(preview_term_of_payment);
    $('#preview_total_gross').empty().append(preview_total_gross);
    $('#preview_total_internal_omzet').empty().append(preview_total_internal_omzet);
    $('#preview_total_discount').empty().append(preview_total_disc + '%');
    $('#preview_total_media_cost').empty().append(preview_total_media_cost);
    $('#preview_total_nett').empty().append(preview_total_nett);
    $('#preview_total_cost_pro').empty().append(preview_total_cost_pro);
    $('#preview_notes').empty().append(preview_notes);
  }

  function recalculate(hot)
  {
    calculateTotal(hot);
    calculateOmzet(hot);
  }