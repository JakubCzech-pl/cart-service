## Shopping Cart Service

### This service provides core functionalities for managing a shopping cart.

- **Add Products to Cart**
- **Remove Products from Cart**
- **Update Cart Quantities**
- **Add Address**

Service accepts only **Content-Type: application/json**



All endpoints and requests examples can be found in *requests.http* file

The application's state is managed synchronously using the Symfony Messenger component.
All application state changes, such as adding or removing products and adding the address, are handled via messages and messages handlers dispatched through the Messenger.

Services should accept Candidate value objects that has validated values in it. With it each service can handle action properly.

All responses from application are created via Factories in *App\Response* namespace.
If response factory needs to be aware of object then it should implement interface that would indicate for concrete strategy.
For example *App\Response\Cart\CartResponseFactory* implements *App\Response\Cart\CartResponseFactoryInterface* with method *setCart* for further creating response with cart details.
