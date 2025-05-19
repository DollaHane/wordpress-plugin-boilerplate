import {registerBlockType} from '@wordpress/blocks'

registerBlockType('boilerplate/experiment-data', {
  title: "Boilerplate Block",
  icon: "database",
  category: "widgets",
  edit() {
    return (
      <div>
        <strong>Boilerplate Data Block</strong>
        <p>This block displays data from the local wpdb</p>
      </div>
    )
  },
  save() {
    return null
  }
})