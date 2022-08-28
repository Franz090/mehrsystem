<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="../../css/main.css"> -->
  <link rel="stylesheet" href="../css/dashboard.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <?php echo isset($additional_script) ? $additional_script : ''; ?>
  <style>
    .container {
      --color-error: #cc3333;
    }
    .form {
      --color-primary: #009579;
      --color-primary-dark: #007f67;
      --color-secondary: #252c6a;
      --color-success: #4bb544;
      --border-radius: 4px;
    }
    .form__input,
    .form__button {
      font: 500 1rem 'Quicksand', sans-serif;
    } 
    .form>*:first-child {
      margin-top: 0;
    } 
    .form>*:last-child {
      margin-bottom: 0;
    }.form__title {
      margin-bottom: 2rem;
      text-align: center;
    } 
    .form__message {
      text-align: center;
      margin-bottom: 1rem;
    } 
    .form__message--error {
      color: var(--color-error);
    } 
    .form__input-group {
      margin-bottom: 1rem;
    } 
    .form__input {
      display: block;
      width: 100%;
      padding: 0.75rem;
      box-sizing: border-box;
      border-radius: var(--border-radius);
      border: 1px solid #dddddd;
      outline: none;
      background: #eeeeee;
      transition: background 0.2s, border-color 0.2s;
    } 
    .form__input:focus {
      border-color: var(--color-primary);
      background: #ffffff;
    } 
    .form__input--error {
      color: var(--color-error);
      border-color: var(--color-error);
    } 
    .form__input-error-message {
      margin-top: 0.5rem;
      font-size: 0.85rem;
      color: var(--color-error);
    } 
    .form__button {
      width: 100%;
      padding: 1rem 2rem;
      font-weight: bold;
      font-size: 1.1rem;
      color: #ffffff;
      border: none;
      border-radius: var(--border-radius);
      outline: none;
      cursor: pointer;
      background: var(--color-primary);
    } 
    .form__button:hover {
      background: var(--color-primary-dark);
    } 
    .form__button:active {
      transform: scale(0.98);
    } 
    .form__text {
      text-align: center;
    }  
  </style>
</head>

<body>