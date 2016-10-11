<div id="<?= $id; ?>"
     ng-controller="MainCtrl"
     ng-init="init('<?= $data; ?>')"
     class="bsuHoursApp"
     ng-cloak>

	<<?= $type; ?>-page></<?= $type; ?>-page>

</div>

<?= $app; ?>