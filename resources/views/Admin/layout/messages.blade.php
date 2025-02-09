    <!-- Show error Message After user login failed -->
     <script type="text/javascript">
      @if(session()->has('_added')>0)
           toastr.success("{{session('_added')}}");
      @endif 
      @if(session()->has('_updated')>0)
           toastr.success("{{session('_updated')}}");
      @endif 
      @if(session()->has('error')>0)
        toastr.error("{{session('error')}}");
      @endif

      @if(count($errors->all())>0)
          @foreach($errors->all() as $error)
            toastr.error("{{$error}}");
          @endforeach
      @endif        
    </script>
