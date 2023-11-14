<script src="<?php echo $url2 ?>vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?php echo $url2 ?>vendor/jquery.min.js"></script>
<script>
  const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
  const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
  const popover = new bootstrap.Popover('.popover-dismiss', {
    trigger: 'focus'
  })
</script>
<script>
  $('#slct').change(function () {
    switch ($('select[id=slct] option').filter(':selected').val()) {
      case "0":
        $('#vreq').text("Accepted file type: MP4 | Max size: 9.5MO");
        break
      case "1":
        $('#vreq').text("Accepted file type: MP3 | Max size: 9.5MO");
        break;
      case "2":
        $('#vreq').text("Accepted file type: PDF | Max size: 9.5MO");
        break;
      default:
        $('#vreq').text("");
        break;
    }
  });
</script>
<script type="text/javascript">
  $('#title').keyup(function () {
    var characterCount1 = $(this).val().length,
      current = $('#current1'),
      maximum = $('#maximum1'),
      theCount = $('#the-count1');
    current.text(characterCount1);
  })
  $('#description').keyup(function () {
    var characterCount2 = $(this).val().length,
      current = $('#current2'),
      maximum = $('#maximum2'),
      theCount = $('#the-count2');
    current.text(characterCount2);
  })
</script>
</body>

</html>
<?php
$connection->close();
?>