$(document).ready( function(){

    $('#thead-milestone-table th .order-by').on('click', function(){
        let index = $('#thead-milestone-table th').index($(this).parent('th'));

        var th = $('#thead-milestone-table th').val();
        $('#thead-milestone-table th').val((th === false) ? true : false)

        sortColumn(index, $('#thead-milestone-table th').val());
    });

    function sortColumn( index, order){

        let tr = $('#tbody-milestone-table tr:nth-child(n)');
        var result = [];

        for (let i = 0; i < tr.length; i++) {
            result[i] = tr.eq(i).html();
        }

        result.sort(function( a, b){
            var arrayA = a.split('</td>')
            var arrayB = b.split('</td>')

            let textA = $('<div>' + arrayA[index].replace('<td>', '') + '</div>').text()
            let textB = $('<div>' + arrayB[index].replace('<td>', '') + '</div>').text()

            return (textA > textB) ? 1: -1;
        });

        $('#thead-milestone-table th .order-by').removeClass('up').removeClass('down');

        if(order === true){
            result.reverse();
            $('#thead-milestone-table th .order-by').eq(index).removeClass('down').addClass('up');
        } else {
            $('#thead-milestone-table th .order-by').eq(index).removeClass('up').addClass('down');
        }

        for (let j = 0; j < tr.length; j++) {
            tr.eq(j).html(result[j]);
        }

    }
});
