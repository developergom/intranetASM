@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('vendor/handsontable/handsontable.full.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="row">
        <div class="col-sm-12">          
            <div id="example"></div>
        </div>
    </div>
</div>    
@endsection

@section('vendorjs')
<script src="{{ url('vendor/handsontable/handsontable.full.js') }}" rel="stylesheet"></script>  
<script src="{{ url('vendor/handsontable/numbro/languages.js') }}" rel="stylesheet"></script>
@endsection

@section('customjs')
<script type="text/javascript">
var
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
    minSpareRows: 1,
    formulas:true,
    contextMenu: true,
    colHeaders: ['No', 'Type', 'Media', 'Edition/Period Start', 'Period End', 'Rate Name', 'Insertion', 'Gross Rate', 'Disc(%)', 'Nett Rate', 'Cost Pro', 'Internal Turnover', 'Remarks'],
    columns: [
      {type: 'numeric'},
      {
            type: 'autocomplete',
            source: [
                    'Digital',
                    'Event',
                    'Product',
                    'Print'
                    ],
            strict: true
        },
      {
        type: 'autocomplete',
        source: [
                    'Autobild',
                    'autobild.co.id',
                    'Bobo',
                    'bobo.co.id',
                    'Cars',
                    'cewekbanget.id',
                    'hai-online.co.id',
                    'Intisari',
                    'intisari.co.id'
                ],
        strict: true,
        visibleRows: 4
      },
      {
        type: 'date'
      },
      {
        type: 'date'
      },
      {
        type: 'autocomplete',
        source: function (query, process) {
                  $.ajax({
                    url: base_url + 'master/advertiseposition/api/all',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        query: query
                    },
                    success: function (response) {
                      console.log("response", response);
                      //process(JSON.parse(response.data)); // JSON.parse takes string as a argument
                      process(response);

                    }
                  });
                },
        strict: true,
        trimDropdown: false
      },
      {
        type: 'numeric'
      },
      {
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      },
      {
        type: 'numeric'
      },
      {
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      },
      {
        type: 'numeric',
        format: 'Rp 0,0.00',
        language: 'id'
      },
      {
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

            console.log(changes);
            for(i = 0;i < ilen; i++){
                //count nett rate
                if(changes[i][1]=='7' || changes[i][1]== '8')
                {
                    var result = dataRef[changes[i][0]][7] - (dataRef[changes[i][0]][7] * dataRef[changes[i][0]][8] / 100);
                    console.log(result);
                    this.setDataAtCell(changes[i][0],9,result);
                }

                if(changes[i][1]=='10')
                {
                    var result = dataRef[changes[i][0]][9] - dataRef[changes[i][0]][10];
                    console.log(result);
                    this.setDataAtCell(changes[i][0],11,result);
                }
            }
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
</script>
@endsection