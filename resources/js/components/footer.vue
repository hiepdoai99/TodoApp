<template>
    <footer>
      <div class="container">
        <div>Copyright © 2023 Your Company</div>
      </div>
    </footer>
  </template>
  
  <script>
  export default {
    name: 'Footer'
  }
  </script>
  
  <style scoped>
  footer {
    background-color: #1D5D9B;
    color: #fff;
    margin-top: 50px;

    position: absolute;
    bottom: 0;
    width: 100%;
    height: 3.5rem; 
  }
  .container {
    max-width: 1200px;
    margin: 0 auto;
  }
  </style>