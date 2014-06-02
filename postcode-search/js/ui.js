(function () {
    
    // 결과 항목
    var Item = Backbone.Model.extend({
            defaults: { callback: function () {} }
        }),
        
        // 결과 목록
        List = Backbone.Collection.extend({
            url: window.postcode_search.ajaxurl, // required
            model: Item,
            parse: function (resp) { 
                return resp.rows
            }
        }),

        // 결과 페이징
        Paging = Backbone.Model.extend({
            defaults: {
                start: 0,
                size: 6
            }
        });

        // 항목 뷰
        ItemView = Backbone.View.extend({
            events: {
                'click': 'select'
            },
            tagName: 'li',
            template: _.template('<a href="#"><%= head %> - <%= tail %> <%= addr %></a>'),
            initialize: function () { this.render() },
            render: function () {
                this.el.innerHTML = this.template(this.model.toJSON());
                return this;
            },
            select: function (e) {
                this.model.get('callback')(this.model.toJSON());
                e.preventDefault();
                e.stopPropagation();
            }
        }),

        // 전체 뷰
        View = Backbone.View.extend({

            events: {
                'click  .js-next:not(.is-disabled)'  : 'load_next',
                'click  .js-prev:not(.is-disabled)'  : 'load_prev',
                'keypress  .js-input' : 'submit',
                'click  .js-submit': 'submit'
            },

            initialize: function () {
                this.listenTo(this.model, 'change:start', this.set_cursor_visibility);
                this.listenTo(this.model, 'change:start', this.load);
                this.set_cursor_visibility();
            },

            submit: function (e) {
                if (_.isUndefined(e.keyCode) ||
                    _.isUndefined(e.which)   ||
                    e.keyCode == 13)
                {

                    this.search(this.$('.js-input').val());
                    e.stopPropagation();
                    e.preventDefault();
                }
            },

            search: function (keyword) {
                this.$('.js-spinner').show();
                this.$('.js-list').hide();

                this.collection.fetch({
                    data: { dong: keyword },
                    success: function () {
                        this.$('.js-spinner').hide();
                        this.$('.js-list').show();

                        this.model.unset('start', { silent: true });
                        this.model.set('start', 0);
                    }.bind(this)
                })
            },

            load: function () {
                var start = this.model.get('start'),
                    end   = start + this.model.get('size'),
                    $list = this.$('.js-list');

                $list.html('');

                _.range(start, end).forEach(function (i) {

                    var model = this.collection.at(i);
                    if (model) {
                        model.set('callback', this.model.get('on_select'));
                        $list.append(new ItemView({ model: model }).el);
                    }

                }.bind(this));
            },

            load_next: function (e) {
                var model = this.model;
                model.set('start', model.get('start') + model.get('size'));
                e.preventDefault();
            },

            load_prev: function (e) {
                var model = this.model;
                model.set('start', model.get('start') - model.get('size'));
                e.preventDefault();
            },

            set_cursor_visibility: function () {
                var start = this.model.get('start'),
                    end   = start + this.model.get('size'),
                    total = this.collection.size(),
                    cls_off = 'is-disabled';

                this.$('.js-prev')[start > 0 ?   'removeClass' : 'addClass'](cls_off);
                this.$('.js-next')[end >= total ? 'addClass' : 'removeClass'](cls_off);

            }
        });

    window.postcode_search['View'] = View;
    window.postcode_search['List'] = List;
    window.postcode_search['Paging'] = Paging;

})();
