<script>
    $(document).ready(function(){
        $('#searchBox').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('autocomplete.fetch') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#dataList').fadeIn();
                        $('#dataList').html(data);
                    }
                });
            }
        });
    })
    $(document).on('click', 'li', function(){
        $('#searchBox').val($(this).text());
        $('#dataList').fadeOut();
    });
    $("#searchBox").change(function() {
        $('#formSearch').submit();
    });
</script>
