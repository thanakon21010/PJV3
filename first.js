$(() => {
 
    display(function () {
      
   
      
    });
  });
  
    function display() {
        console.log(window.location.origin)
        var url = window.location.origin + "/PJV3/api.php/agency/get";

          $.getJSON(url).done(function (data) {
            console.log(JSON.stringify(data));

            var line = "";
            $.each(data, function (k, item) {
              console.log(item);
              line += "<tr>";
              line += "<td align='center'>" + "<button><a href='http://localhost/PJV3/edit.html'>info</a></button>" + "</td>";
              line += "<td align='center'>" + item.agency_code + "</td>";
              line += "<td align='center'>" + item.agency_name + "</td>";
              line += "<td align='center'>" + item.agency_contact_name + "</td>";
              line += "<td align='center'>" + item.agency_email + "</td>";
              line += "<td align='center'>" + item.agency_telno + "</td>";
              line += "<td align='center'>" + item.agency_price + "</td>";
              line += "</tr>";
            });

            $(document).ready(function() {
                $('#myTable').DataTable({
                    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                });
            } );
            $("#tblData").append(line);
            });
          }
        


          