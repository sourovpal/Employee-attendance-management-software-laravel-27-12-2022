<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">


<div style="display: flex;
    justify-content: center;
    align-items: center;
    height: 500px;
">
    
    <form method="post">
    @isset($successMessage)
        <div class="alert alert-success"> {{ $successMessage }}</div>
    @endisset
    @csrf
    <input class="form-control" type="text" name="commend" style="width:450px;">
    <br>
    <select class="form-control" name="select_commend">
        <option value="">Select Clear</option>
        <option value="cache:clear">Cache Clear</option>
        <option value="config:clear">Config Clear</option>
        <option value="view:clear">view Clear</option>
        <option value="route:clear">route Clear</option>
        <option value="optimize:clear">Optimize Clear</option>
    </select>
    <br>
    <button class="btn btn-info">RUN</button>
        
    </form>
<div>
