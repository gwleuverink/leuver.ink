---
extends: _layouts.blog
section: article
tags: [Livewire, Laravel, Package]
published: true

title: Organize Livewire Properties with Groups
description: Managing complex forms with many properties in Livewire can get messy. Property groups help organize related fields for cleaner validation, manipulation, and debugging.
date: 2025-11-19
readTime: 6 minute read
image: assets/images/livewire-property-groups.jpg
---

Ever found yourself writing the same validate() arrays repeatedly across different methods? Or hunting through your component to figure out which properties belong to which step of your multi-step form?

Complex forms in Livewire lead to scattered validation logic where field relationships are buried in method calls rather than clearly declared.

This is exactly why I built <a href="https://github.com/gwleuverink/livewire-property-groups" target="_blank" rel="noopener">livewire-property-groups</a>. It lets you organize related properties into named groups for step-by-step validation and cleaner form management.

```php
#[Group('billing')]
public $address;

public function submit()
{
    $this->group('billing')->validate();

    // ...
}
```

According to Packagist, I'm pretty much the only one using this package. I've kept it to myself for too long - time to put it in the spotlight because I genuinely think it solves a problem most Livewire developers run into eventually.

### Multi-Step Checkout Example

Here's a checkout form that validates each step before allowing progress:

```php
use Leuverink\PropertyAttribute\Group;
use Leuverink\PropertyAttribute\WithGroups;

class Checkout extends Component
{
    use WithGroups;

    #[Group('billing')]
    public $billingName;

    #[Group('billing')]
    public $billingAddress;

    #[Group('shipping')]
    public $shippingAddress;

    #[Group('shipping')]
    public $shippingMethod;

    #[Group('payment')]
    public $cardNumber;

    #[Group('payment')]
    public $expiryDate;

    public $currentStep = 'billing';

    public function nextStep() // [tl! **]
    { // [tl! **]
        $steps = ['billing', 'shipping', 'payment'];

        // Validate current step before advancing [tl! **]
        $this->group($this->currentStep)->validate(); // [tl! **]

        // Advance step
        $currentIndex = array_search($this->currentStep, $steps);
        $this->currentStep = $steps[$currentIndex + 1] ?? $this->currentStep;
    } // [tl! **]

    public function completeOrder() // [tl! focus]
    { // [tl! focus]
        // Final validation of all steps [tl! focus]
        $this->group(['billing', 'shipping', 'payment'])->validate(); // [tl! focus]

        // Complete order...
    } // [tl! focus]
}
```

Notice how each step's properties are clearly grouped and validation happens per-group. No more manually tracking which fields belong to which step! (Validation rules omitted for brevity - they work exactly as you'd expect.)

Beyond multi-step forms, property groups are perfect for data filter components (reset date filters separately from category filters), user profile forms with sectioned save actions, or any component where related properties need coordinated validation and manipulation.

### Works with Form Objects

Using form objects? Property groups work there too, giving you the flexibility to validate from inside the form or from the form object's enclosing component:

```php
class CheckoutForm extends Form
{
    use WithGroups;

    #[Group('billing')]
    public $billingName;

    #[Group('shipping')]
    public $shippingName;
}

class Checkout extends Component
{
    public CheckoutForm $checkoutForm; // [tl! focus:start]

    public function validateBilling()
    {
        // From outside the form object
        $this->checkoutForm->group('billing')->validate();
    } // [tl! focus:end]
}
```

This eliminates the need for proxy validation methods in your components. Step management happens in the component, validation happens in the form - clean separation with no extra boilerplate.

Beyond validation, property groups offer several convenient methods for working with your data:

### Useful Methods

Groups come with handy methods for common operations:

```php
// Get all properties as array
$billingData = $this->group('billing'); // [tl! highlight]

// Get property names or values
$fields = $this->group('billing')->keys(); // [tl! highlight:1]
$values = $this->group('billing')->values();

// Access as array or object
$billingName = $this->group('billing')['billingName']; // [tl! highlight:1]
$billingName = $this->group('billing')->billingName;

// Iterate over properties
$this->group('billing')->each(fn($value, $name) => /* */); // [tl! highlight]

// Validate single or multiple groups
$this->group('billing')->validate(); // [tl! highlight:1]
$this->group(['billing', 'shipping'])->validate();

// Reset properties to initial values
$this->group('shipping')->reset(); // [tl! highlight]

// Get data and reset in one operation
$data = $this->group('billing')->pull(); // [tl! highlight]

// Get all grouped properties (excluding non-grouped)
$allGroups = $this->group(); // [tl! highlight]

// Debug group contents (chainable)
$this->group('payment')->dump()->validate(); // [tl! highlight:1]
$this->group('payment')->dd();
```

### Debugging Helpers

When developing complex forms, debugging becomes much easier with groups:

```php
// Quick debug of only the data you care about
$this->group('billing')->dump();

// Debug and continue (chainable)
$validated = $this->group('payment')->dump()->validate();

// Debug current step in multi-step forms
$this->group($this->currentStep)->dump();

// Dump and die in place
$this->group('users')->each(
    fn(User $user) => $user->notify(SomeEvent::class)
)->dd();
```

### Livewire v4 Support

Version 2.0 adds full compatibility with Livewire v4-beta, so you can use property groups in modern Laravel applications without compatibility concerns.

### Installation

```bash
composer require leuverink/livewire-property-groups
```

Add the `WithGroups` trait and start organizing properties with `#[Group]` attributes.

### The Bottom Line

Property groups solve a simple problem: keeping related fields organized. Instead of scattering field references across methods, you declare relationships once alongside the properties themselves.

Need to build a product filter with "Clear date filters" and "Reset advanced options" buttons? - no sweat.

When that checkout form inevitably grows from 6 fields to 20, or when you need to add a new step, your validation logic stays clean and your sanity stays intact.

— Willem
