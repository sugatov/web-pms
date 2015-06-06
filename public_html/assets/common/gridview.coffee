define [
  'knockout-es5'
  'text!./gridview.html'
  'lodash/collection/find'
# './gridview/search-criterion'
], (ko, tpl, find) ->
  ko.components.register 'gridview', {
    viewModel: (params) ->
      self                = this
      this.items          = params.items
      this.columns        = params.columns
      this.onSelect       = params.onSelect
      this.search         = params.search
      this.searchCriteria = []
      this.selectedId     = -1

      ko.track this, ['selectedId']

      if ko.isObservable this.items
        this.items.subscribe (val) ->
          this.selectedId = -1

      ko.defineProperty this, 'haveSearch', ->
        if typeof self.search is 'function'
          return true
        else
          return false

      this.criterionChange = (criterion) ->
        if self.haveSearch
          existing = find self.searchCriteria, {name: criterion.name}
          if existing is undefined and criterion.value.length > 0
            self.searchCriteria.push criterion
          else
            if criterion.value.length > 0
              existing.value = criterion.value
            else
              index = self.searchCriteria.indexOf existing
              self.searchCriteria.splice index, 1
          criteria = {}
          for column in self.searchCriteria
            criteria[column.name] = column.name
          self.search criteria

      # @selectItem = (item, event) =>
      #   @selectedId = item.id
      #   if typeof @onSelect is 'function'
      #     @onSelect item
    template: tpl
  }
