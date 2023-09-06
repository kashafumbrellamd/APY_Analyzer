<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <title>Update Price</title>
  </head>
  <body>
    <section class="back_sign__ login__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <div class="main_signUp">
                    <h1 class="regiter_heading_h">Update Rates</h1>
                    <div class="row">
                        <form method="POST" action="{{ route('update_price') }}">
                            @csrf
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Rate Type</th>
                                    <th scope="col">Current Rate</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <input type="hidden" name="bank_id" value="{{ $id }}">
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($prices as $price)
                                    <tr>
                                        <th scope="row">{{ $count }}</th>
                                        <td>{{ $price->name }}</td>
                                        {{-- <td>{{ $price->current_rate }}</td> --}}
                                        <input type="hidden" name="rate_type_id[]" value="{{ $price->rate_type_id }}">
                                        <td><input type="text" class="form-control" name="current_rate[]" value="{{ $price->current_rate }}"></td>
                                    </tr>
                                    @php
                                        $count++;
                                    @endphp
                                @endforeach
                                </tbody>
                              </table>
                              <div class="d-flex justify-content-end">
                                  <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                        </form>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
