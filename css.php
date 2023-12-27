<style>
.checkboxz input[type="checkbox"] {
    display: none;
}

.checkboxz label {
    display: inline-block;
    position: relative;
    padding-left: 30px;
    cursor: pointer;
}

.checkboxz label::before {
    content: "";
    display: inline-block;
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
    border: 2px solid #000;
    background-color: #fff;
}

.checkboxz input[type="checkbox"]:checked + label::before {
    background-color: #2ecc71;
    border-color: #2ecc71;
}

.checkboxz label::after {
    content: "\2713";
    display: none;
    position: absolute;
    left: 5px;
    top: -1px; /* Adjusted top position */
    font-size: 18px;
    color: #000;
}

.checkboxz input[type="checkbox"]:checked + label::after {
    display: inline-block;
    position: absolute;
    left: 5px;
    top: -1px; /* Adjusted top position */
    font-size: 18px;
    color: #000;
}

/* Style the custom checkbox when checked */
.checkboxz input[type="checkbox"]:checked + label::before {
  background-color: #2ecc71;
  border-color: #2ecc71;
}

.tombol-mutasikan{
    width:1250px;
    left: 100px;
    position: sticky;
    top: 60px;
    z-index: 100; 
    background-color: #E4E9F7;
}
</style>