$(document).ready( function(){

    for(i = 0; i < $('#thead-sort th').length; i++){        
        $('#thead-sort th').eq(i).html(
            $('#thead-sort th').eq(i).html()+'<span>     &#x2B18;<span>');
    }

    $('#thead-sort th').on('click', function(){
        let index = $('#thead-sort th').index(this);
        while(index + 1){
            var th = $('#thead-sort th').val();
            $('#thead-sort th').val((th === false)? true: false)

            sortColumn(index, $('#thead-sort th').val());
            
            break;
        }
    });

    function sortColumn( index, order){
        let tr = $('#tbody-sort tr:nth-child(n)');
        var result = [];

        for (let i = 0; i < tr.length; i++) {
            result[i] = tr.eq(i).html();
            result.sort(function( a, b){
                var arrayA = a.split('</td>')
                var arrayB = b.split('</td>')
                return (arrayA[index] > arrayB[index]) ? 1: -1;
            });
            $('#thead-sort th span').html('   &#x2B18;');
            $('#thead-sort th span').eq(index).html('   &#x2BC6;');
            if(order === true){
                result.reverse();
                $('#thead-sort th span').eq(index).html('   &#x2BC5;');
            }
        }

        for (let j = 0; j < tr.length; j++) {
            tr.eq(j).html(result[j]);
        }

    }
});