<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Location" content="http://example.com/">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>

<style>
/* ===== SELECT VISIBILITY FIX (bootstrap-select + plain select) ===== */
select, select.form-control {
  background:#fff !important;
  color:#111 !important;
}
select option { background:#fff !important; color:#111 !important; }

/* bootstrap-select (selectpicker) */
.bootstrap-select > .dropdown-toggle,
.bootstrap-select > .dropdown-toggle:focus,
.bootstrap-select > .dropdown-toggle:hover {
  background:#fff !important;
  color:#111 !important;
  border:1px solid #d0d5dd !important;
}
.bootstrap-select .filter-option,
.bootstrap-select .filter-option-inner,
.bootstrap-select .filter-option-inner-inner {
  color:#111 !important;
  font-weight:500;
}
.bootstrap-select .dropdown-menu,
.bootstrap-select .dropdown-menu * {
  background:#fff !important;
  color:#111 !important;
}
.bootstrap-select .dropdown-menu li a:hover,
.bootstrap-select .dropdown-menu li.selected a {
  background:#eaf3ff !important;
  color:#111 !important;
}
.bootstrap-select.show > .dropdown-toggle {
  border-color:#3b82f6 !important;
  box-shadow:0 0 0 2px rgba(59,130,246,.15);
}
.bootstrap-select .bs-searchbox input,
.bootstrap-select .bs-searchbox .form-control {
  background:#fff !important;
  color:#111 !important;
  border:1px solid #d0d5dd !important;
}
</style>

<!-- jQuery -->
