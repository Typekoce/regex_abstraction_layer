# Regex Abstraction Layer
Regex Abstraction Layer

* The aim of this project is to create a friendly set of commands that translates to regular expression. 
Initially this project will be written in PHP however the intention that this project will be language agnostic

## Example abstraction syntax

*** psuedo code ***
$telephone->starts(0700)->or->(brackets(0700))->then->(000)->again(twice());

*** Simple syntax ***
1. Telephone starts with 4 digits

2. Contains 07
