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

  function isEmptyRow(instance, row) {
    var rowData = instance.getData()[row];

    for (var i = 0, ilen = rowData.length; i < ilen; i++) {
      if (rowData[i] !== null) {
        return false;
      }
    }

    return true;
  }

  function defaultValueRenderer(instance, td, row, col, prop, value, cellProperties) {
    var args = arguments;

    if (args[5] === null && isEmptyRow(instance, row)) {
      args[5] = tpl[col];
      td.style.color = '#999';
    }
    else {
      td.style.color = '';
    }
    Handsontable.renderers.TextRenderer.apply(this, args);
  }

  hot1 = new Handsontable(container, {
    startRows: 1,
    height: 200,
    minSpareRows: 1,
    formulas:true,
    contextMenu: true,
    colHeaders: ['No', 'Type', 'Rate Name', 'Media', 'Edition/Period Start', 'Period End', 'Omzet Type', 'Insertion', 'Gross Rate', 'Disc(%)', 'Nett Rate', 'Omzet Internal', 'Remarks'],
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
      {}
    ],
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
                        instance.setDataAtCell(changes[loop_index][0],8,gross_rate);
                      }
                  });
                }

                //count nett rate
                if(changes[i][1]=='8' || changes[i][1]== '9')
                {
                    var result = dataRef[changes[i][0]][8] - (dataRef[changes[i][0]][8] * dataRef[changes[i][0]][9] / 100);
                    //console.log(result);
                    this.setDataAtCell(changes[i][0],10,result);
                    this.setDataAtCell(changes[i][0],11,result);

                    calculateTotal(this);
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
    }/*,
    cells: function (row, col, prop) {
      var cellProperties = {};

      //cellProperties.renderer = defaultValueRenderer;

      return cellProperties;
    },
    beforeChange: function (changes) {
      var instance = hot1,
        ilen = changes.length,
        clen = instance.colCount,
        rowColumnSeen = {},
        rowsToFill = {},
        i,
        c;

      for (i = 0; i < ilen; i++) {
        // if oldVal is empty
        if (changes[i][2] === null && changes[i][3] !== null) {
          if (isEmptyRow(instance, changes[i][0])) {
            // add this row/col combination to cache so it will not be overwritten by template
            rowColumnSeen[changes[i][0] + '/' + changes[i][1]] = true;
            rowsToFill[changes[i][0]] = true;
          }
        }
      }
      for (var r in rowsToFill) {
        if (rowsToFill.hasOwnProperty(r)) {
          for (c = 0; c < clen; c++) {
            // if it is not provided by user in this change set, take value from template
            if (!rowColumnSeen[r + '/' + c]) {
              changes.push([r, c, null, tpl[c]]);
            }
          }
        }
      }
    }*/
  });

  //hot1.loadData(data);

  function calculateTotal(hot)
  {
    var data = hot.getData();
    total_gross = 0;
    //total_disc = 0;
    total_nett = 0;
    total_omzet = 0;
    //console.log(data.length);
    //console.log(data);
    for(x=0;x<data.length;x++)
    {
      var nett = data[x][8] - (data[x][8] * data[x][9] / 100);
      total_gross += data[x][8];
      //total_disc += data[x][9];
      total_nett += nett;
      total_omzet += nett;
    }
    
    total_disc = Math.ceil((total_gross - total_nett) / total_gross * 100);
    
    $('#summary_total_gross').val(total_gross);
    $('#summary_total_disc').val(total_disc);
    $('#summary_total_nett').val(total_nett);
    $('#summary_total_internal_omzet').val(total_omzet);
  }