<div class="wrap">
	<h2>Bsu Hours Manager Shortcode Creator</h2>

	<div
		id="<?= $id; ?>"
	    ng-controller="shortcodeController"
	    ng-init="init('<?= $data; ?>')"
	    ng-cloak
		ng-hide="loading">

		<h2>Locations</h2>

		<select size="10" ng-multiple="true"
		        ng-model="form.selectedLocations"
		        data-ng-options="location.ID as location.post_title for location in form.locations"
		        multiple ng-change="createShortcode()">
		</select>
		<br/>

		<label for="viewTypes">Select View Type:</label> <br/>
		<select name="viewTypes"
		        ng-model="form.viewType"
		        ng-options="type.value as type.name for type in form.viewTypes"
		        ng-change="createShortcode()"></select>

		<br><br>

		<label for="title" ng-show="form.viewType == 'location'">Title</label><br/>
		<input type="text"
		       ng-model="form.title"
		       ng-show="form.viewType == 'location'"
		       ng-change="createShortcode()"/>
		<br/><br/>
		<label for="shortcode">Shortcode:</label> <br>

		<input type="text"
		       ng-model="form.shortcode"
		       select-on-click
		       size="35"/>

	</div>
</div>

<?= $app; ?>