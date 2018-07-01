import icecream from './icecream.jpg';
import beer from './beer.jpg';
import burger from './burger.jpg';

export default function getImage(name) {
  let url = '';
  switch (name) {
    case 'Beer': 
      url = beer;
      break;
    case 'Burger': 
      url = burger;
      break;    
    default: 
      url = icecream;
      break;
  }

  return `/js/${url}`;
}
