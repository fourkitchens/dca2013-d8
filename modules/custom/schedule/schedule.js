(function ($) {
  var App = Ember.Application.create({LOG_TRANSITIONS: true});
  window.App = App;

  App.SessionModel = Ember.Object.extend({
    title: '',
    presenters: '',
    tag: ''
  });

  App.ScheduleModel = Ember.Object.extend({
    allSessions: [],
    filteredSessions: [],

    resetScheduleInfo: function() {
      var self = this;
      var dummyData = [
        {
          title: 'Practical Drupal Commerce',
          presenters: 'Ryan Szrama',
          tag: 'Site building'
        },
        {
          title: 'Preying on the drupal_alter()',
          presenters: 'Matt Kleve',
          tag: 'Development'
        },
        {
          title: 'How to Seal the Deal Without Writing a Proposal',
          presenters: 'Tim Hamilton',
          tag: 'Business and marketing'
        },
        {
          title: 'Sustainable theme development with Fusion',
          presenters: 'Jason Yergeau',
          tag: 'Design, Themeing and UX'
        }
      ];

      self.set('allSessions', dummyData.map(function(session) {
        return App.SessionModel.create(session);
      }));
    }
  });

  App.ScheduleView = Ember.View.extend({
    templateName: 'schedule'
  });

  App.ScheduleController = Ember.ObjectController.extend({

  });

  App.ScheduleRoute = Ember.Route.extend({
    model: function() {
      App.scheduleModel = App.ScheduleModel.create();
      App.scheduleModel.resetScheduleInfo();
      return App.scheduleModel;
    }
  });

  App.Router.map(function() {
    this.route('schedule', { path: '/' });
  });

})(jQuery);
