App = {};

App.Model = Backbone.Model.extend({
	name: null,
	parse: function(response) {
		if (this.name in response) {
			response = response[this.name];
		}
		return response;
	}
});