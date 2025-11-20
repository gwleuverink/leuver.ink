---
extends: _layouts.blog
section: article
tags: [Livewire, Laravel, Forms]
published: true

title: Organize Livewire Properties with Groups
description: Managing complex forms with many properties in Livewire can get messy. Property groups help organize related fields for cleaner validation, manipulation, and debugging.
date: 2025-11-19
readTime: 6 minute read
---

Ever found yourself writing the same validateOnly arrays repeatedly across different methods? Or hunting through your component to figure out which properties belong to which step of your multi-step form?

Complex forms in Livewire lead to scattered validation logic where field relationships are buried in method calls rather than clearly declared.

This is exactly why I built <a href="https://github.com/gwleuverink/livewire-property-groups" target="_blank" rel="noopener">livewire-property-groups</a>. It lets you organize related properties into named groups for step-by-step validation and cleaner form management.

According to Packagist, I'm pretty much the only one using this package. I've kept it to myself for too long - time to put it in the spotlight because I genuinely think it solves a problem most Livewire developers run into at some point.

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

    public function nextStep()
    {
        $steps = ['billing', 'shipping', 'payment'];

        // Validate current step before advancing
        $this->group($this->currentStep)->validate();

        // Advance step
        $currentIndex = array_search($this->currentStep, $steps);
        $this->currentStep = $steps[$currentIndex + 1] ?? $this->currentStep;
    }

    public function completeOrder()
    {
        // Final validation of all steps
        $this->group(['billing', 'shipping', 'payment'])->validate();

        //
    }
}
```

Notice how each step's properties are clearly grouped and validation happens per-group. No more manually tracking which fields belong to which step! (Validation rules omitted for brevity - they work exactly as you'd expect.)

### The Alternative Without Groups

Without property groups, you'd need to manually track which fields belong to each step:

```php
public function validateBillingStep()
{
    $this->validateOnly([
        'billingName',
        'billingAddress'
    ]);
}

public function validateShippingStep()
{
    $this->validateOnly([
        'shippingAddress',
        'shippingMethod'
    ]);
}

public function validatePaymentStep()
{
    $this->validateOnly([
        'cardNumber',
        'expiryDate'
    ]);
}

// And so on for each step...
```

This approach is error-prone and doesn't scale well. Properties are referenced by string names scattered across methods - rename a property and validation breaks.

What belongs to which step is now spread throughout your component instead of being clearly declared alongside the properties themselves. Groups allow for colocation.

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
    public CheckoutForm $checkoutForm;

    public function validateBilling()
    {
        // From outside the form object
        $this->checkoutForm->group('billing')->validate();
    }
}
```

This eliminates the need for proxy validation methods in your components. Step management happens in the component, validation happens in the form - clean separation with no extra boilerplate.

Beyond validation, property groups offer several convenient methods for working with your data:

### Useful Methods

Groups come with handy methods for common operations:

```php
// Get all properties as array
$billingData = $this->group('billing');

// Get property names or values
$fields = $this->group('shipping')->keys();
$values = $this->group('payment')->values();

// Destructuring assignment with values
[$billingName, $billingAddress] = $this->group('billing')->values();

// Reset specific step to initial values
$this->group('shipping')->reset();

// Get data and reset in one operation
$data = $this->group('billing')->pull();

// Debug group contents (chainable)
$this->group('payment')->dump()->validate();

// Validate multiple groupsw at once
$this->group(['billing', 'shipping'])->validate();
```

### Debugging Made Easy

When developing complex forms, debugging becomes much easier with groups:

```php
// Quick debug of only the data you care about
$this->group('billing')->dump();

// Debug and continue (chainable)
$validated = $this->group('payment')->dump()->validate();

// Debug current step in multi-step forms
$this->group($this->currentStep)->dump();
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
