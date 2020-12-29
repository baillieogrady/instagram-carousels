import './App.css';

function App() {
  return (
    <div className="App">
      <a href="#" class="header__icon z-50 w-brand-20 h-brand-20 flex justify-center items-center">
      <div class="relative h-full w-full">
        <span class="header__border"></span>
        <span class="header__border"></span>
        <span class="header__border"></span>
        <span class="header__border"></span>
        <div class="header__burger absolute left-brand-1/2 top-brand-1/2 transform -translate-x-1/2 -translate-y-1/2 z-40">
          <span class="header__line w-brand-3 lg:w-4 xl:w-5 h-brand-1 block"></span>
          <span class="header__line w-brand-3 lg:w-4 xl:w-5 h-brand-1 block"></span>
          <span class="header__line w-brand-3 lg:w-4 xl:w-5 h-brand-1 block"></span>
        </div>
      </div>
    </a>
    </div>
  );
}

export default App;
