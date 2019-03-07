$(document).ready(function(){
	
	var t = $('#tb_produto').DataTable({
		paging:   false,
		bFilter: false, 
		bInfo: false
	});
       
 		// add row
    $('#addProduto').click(function () {
    	
        //t.row.add( [1,2,3] ).draw();
        var rowHtml = $("#newRow").find("tr")[0].outerHTML
        console.log(rowHtml);
        t.row.add($(rowHtml)).draw();
    });
 
});