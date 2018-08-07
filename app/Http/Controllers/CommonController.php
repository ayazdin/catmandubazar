<?php
namespace App\Http\Controllers;

use App\Models\Quotes;
use App\Models\Category;
use App\Models\User;
use App\Models\Users_data;
use App\Models\Comments;
use App\Models\Option;
use App\Models\OrderStatus;
use App\Models\Cart;
use App\Models\Postcat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Session;

class CommonController extends Controller
{
		public function getFinalPrice($quote)
    {
        try{
            $extraInfo = array();
            $adjustment = 0;
            $category = Category::where('id', $quote->catid)->first();

            //return print_r($category);

            $exchange_rate = $this->getExchangeRate();//Option::where('var_name', 'exchange_rate')->first();

            $totalBuyPrice = $quote->buy_price * $quote->quantity;

            $totalCostForUSParty = $totalBuyPrice + $quote->sales_tax + $quote->dom_shipping;

            $totalWeight = ceil($quote->weightlbs * $quote->quantity);
            $totalDimentionalWeight1 = ($quote->length * $quote->width * $quote->height) / 139;
            $totalDimentionalWeight = ceil($totalDimentionalWeight1 * $quote->quantity);

            $weightConsidered = ($totalWeight>$totalDimentionalWeight)?$totalWeight:$totalDimentionalWeight;


            //$aisFirstQty = $weightConsidered * 6;
            //$aisSecondQty = $weightConsidered * ($quote->quantity - 1) * 5.5;

                $totalIntlShipping = $weightConsidered * 5;


                $usPartyCommission = ($quote->us_profit * $totalCostForUSParty) / 100;

                $nepalPartyCommission = ($quote->nep_profit * ($totalCostForUSParty + $totalIntlShipping)) / 100;


                //return "First: ".$aisFirstQty." Second: ".$aisSecondQty." Us Commis: ".$usPartyCommission. " Nep Com: ".$nepalPartyCommission;

                //return "Buy Price: ".$totalBuyPrice." --- Weight Considered: ".$weightConsidered." --- Total Shipping: ".$totalIntlShipping." --- US Profit(".$quote->us_profit."): ".$usPartyCommission." --- Nep Profit:".$nepalPartyCommission;

            $internationalShipping = $totalIntlShipping + $usPartyCommission + $nepalPartyCommission;
            //return $internationalShipping;

                $firstSubTotal = $totalCostForUSParty + $internationalShipping;



                $custom = (($firstSubTotal * $category->tariff) / 100) +
                                    (($firstSubTotal * $category->ecs) / 100) +
                                        ($category->flat_rate / $exchange_rate) +
                                        ($category->volume_rate / $exchange_rate);

            $discount = (($totalIntlShipping * $quote->adjustment) / 100) + $quote->adj_cost;

            $subTotal = $firstSubTotal + $custom - $discount;

            $vat = ($category->vat * $subTotal) / 100;

            $grandTotal = $subTotal + $vat;

            //return "intl: ".$internationalShipping." --- Custom: ".$custom." --- discount: ".$discount." --- Subtotal: ".$subTotal." --- Vat: ".$vat." --- Total: ".$grandTotal;

            $extraInfo['category'] = $category->category;
						if($quote->url!="")
							$extraInfo['purl'] = $this->getHostName($quote->url);
            $extraInfo['tariff'] = $category->tariff;
            $extraInfo['custom'] = number_format($custom,2, '.', '');
            $extraInfo['discount'] = number_format($discount,2, '.', '');
            $extraInfo['subtotal'] = number_format($subTotal, 2, '.', '');
            $extraInfo['vat'] = number_format($vat, 2, '.', '');
            $extraInfo['intlShip'] = number_format($internationalShipping, 2, '.', '');
            $extraInfo['finalCost'] = number_format($grandTotal, 2, '.', '');
            $extraInfo['nrsCost'] = number_format($grandTotal*$exchange_rate, 2, '.', '');

            //return print_r($extraInfo);
        }
        catch ( Illuminate\Database\QueryException $e) {
            return response()->json($e->errorInfo);
        }
        return $extraInfo;
    }

    public function getFinalPrice2($quote)
    {
        try{
            $extraInfo = array();
            $adjustment = 0;
            $category = Category::where('id', $quote->catid)->first();

            //return print_r($category);

            $exchange_rate = $this->getExchangeRate();//Option::where('var_name', 'exchange_rate')->first();

            $totalBuyPrice = $quote->buy_price * $quote->quantity;

            $totalCostForUSParty = $totalBuyPrice + $quote->sales_tax + $quote->dom_shipping;

            $totalWeight = ceil($quote->weightlbs * $quote->quantity);
            $totalDimentionalWeight1 = ($quote->length * $quote->width * $quote->height) / 139;
            $totalDimentionalWeight = ceil($totalDimentionalWeight1 * $quote->quantity);

            $weightConsidered = ($totalWeight>$totalDimentionalWeight)?$totalWeight:$totalDimentionalWeight;


            $aisFirstQty = $weightConsidered * 5;
            $aisSecondQty = $weightConsidered * ($quote->quantity - 1) * 5.5;

                $totalIntlShipping = $aisFirstQty + $aisSecondQty;


                $usPartyCommission = ($quote->us_profit * $totalCostForUSParty) / 100;

                $nepalPartyCommission = ($quote->nep_profit * ($totalCostForUSParty + $totalIntlShipping)) / 100;


                //return "First: ".$aisFirstQty." Second: ".$aisSecondQty." Us Commis: ".$usPartyCommission. " Nep Com: ".$nepalPartyCommission;

                //return "Buy Price: ".$totalBuyPrice." --- Weight Considered: ".$weightConsidered." --- Total Shipping: ".$totalIntlShipping." --- US Profit(".$quote->us_profit."): ".$usPartyCommission." --- Nep Profit:".$nepalPartyCommission;

            $internationalShipping = $totalIntlShipping + $usPartyCommission + $nepalPartyCommission;
            //return $internationalShipping;

                $firstSubTotal = $totalCostForUSParty + $internationalShipping;



                $custom = (($firstSubTotal * $category->tariff) / 100) +
                                    (($firstSubTotal * $category->ecs) / 100) +
                                        ($category->flat_rate / $exchange_rate) +
                                        ($category->volume_rate / $exchange_rate);

            $discount = (($totalIntlShipping * $quote->adjustment) / 100) + $quote->adj_cost;

            $subTotal = $firstSubTotal + $custom - $discount;

            $vat = ($category->vat * $subTotal) / 100;

            $grandTotal = $subTotal + $vat;

            //return "intl: ".$internationalShipping." --- Custom: ".$custom." --- discount: ".$discount." --- Subtotal: ".$subTotal." --- Vat: ".$vat." --- Total: ".$grandTotal;

            $extraInfo['category'] = $category->category;
            $extraInfo['purl'] = $this->getHostName($quote->url);
            $extraInfo['tariff'] = $category->tariff;
            $extraInfo['custom'] = number_format($custom,2, '.', '');
            $extraInfo['discount'] = number_format($discount,2, '.', '');
            $extraInfo['subtotal'] = number_format($subTotal, 2, '.', '');
            $extraInfo['vat'] = number_format($vat, 2, '.', '');
            $extraInfo['intlShip'] = number_format($internationalShipping, 2, '.', '');
            $extraInfo['finalCost'] = number_format($grandTotal, 2, '.', '');
            $extraInfo['nrsCost'] = number_format($grandTotal*$exchange_rate, 2, '.', '');

            //return print_r($extraInfo);
        }
        catch ( Illuminate\Database\QueryException $e) {
            return response()->json($e->errorInfo);
        }
        return $extraInfo;
    }

    public function getFinalPrice1($quote)
    {
    	try{
    		$extraInfo = array();
            $adjustment=0;
    		$category = Category::where('id', $quote->catid)->first();

    		$totalBuyPrice = $quote->buy_price * $quote->quantity;
            $usCommission = (10 * $totalBuyPrice) / 100;

    		$totalWeight = $quote->weightlbs * $quote->quantity;
    		$totalDimentionalWeight = (($quote->length * $quote->width * $quote->height) * $quote->quantity) / 139;

    		$actualIntlShippingFirstA = $totalWeight * 5;
    		$actualIntlShippingFirstB = $totalDimentionalWeight * 5;
    		if($actualIntlShippingFirstA > $actualIntlShippingFirstB)
    			$actualIntlShippingFirst = $actualIntlShippingFirstA;
    		else
    			$actualIntlShippingFirst = $actualIntlShippingFirstB;

    		$actualIntlShippingSecond = 0;

    		if($quote->quantity > 1)
    		{
    			$actualIntlShippingSecondA = $totalWeight * 5 * ($quote->quantity-1);
    			$actualIntlShippingSecondB = $totalDimentionalWeight * 5 * ($quote->quantity-1);
    			if($actualIntlShippingSecondA > $actualIntlShippingSecondB)
    				$actualIntlShippingSecond = $actualIntlShippingSecondA;
    			else
    				$actualIntlShippingSecond = $actualIntlShippingSecondB;
    		}

    		$nepalPartyCost = $totalBuyPrice + $quote->sales_tax + $quote->dom_shipping + $usCommission + $actualIntlShippingFirst + $actualIntlShippingSecond;
    		$nepalPartyCommission = (15 * $nepalPartyCost) / 100;

    		$intlShipping = $actualIntlShippingFirst + $actualIntlShippingSecond + $usCommission + $nepalPartyCommission;

    		$intlShippingForDiscount = $actualIntlShippingFirst + $actualIntlShippingSecond + $nepalPartyCommission;

    		if($quote->adjustment!="" and $quote->adj_cost!="")
    			$adjustment = (($intlShippingForDiscount * $quote->adjustment)/100) + ($intlShippingForDiscount - $quote->adj_cost);

    		$subTotalA = $nepalPartyCost + $nepalPartyCommission;

    		if($category->tariff!="")
					$customPercent = ($subTotalA * $category->tariff) / 100;
				else
					$customPercent = 0;
				$subTotalB = $subTotalA + $customPercent;

				$subTotal = $subTotalB - $adjustment;

				if($category->vat!="")
					$vat = ($subTotal * $category->vat) / 100;
				else
					$vat = 0;
				$grandTotal = $subTotal + $vat;

				$extraInfo['category'] = $category->category;
	            $extraInfo['purl'] = $this->getHostName($quote->url);
	            $extraInfo['tariff'] = $category->tariff;
				$extraInfo['custom'] = number_format($customPercent,2);
	            $extraInfo['discount'] = number_format($adjustment,2);
				$extraInfo['subtotal'] = number_format($subTotal, 2);
				$extraInfo['vat'] = number_format($vat, 2);
				$extraInfo['intlShip'] = number_format($intlShipping, 2);
				$extraInfo['finalCost'] = $grandTotal;

			}catch ( Illuminate\Database\QueryException $e) {
			    return response()->json($e->errorInfo);
			}
			return $extraInfo;
    }

    public function canCheckout()
    {
    	if(Auth::check())
    	{
    		$user = Auth::user();
    		try{
					$quotes = Quotes::where('quote_status', '=', 'accepted')
				                    ->where('userid', '=', $user->id)
                                    ->where(DB::raw("DATE_ADD(DATE(quoted_date), INTERVAL 7 DAY)"), '>', DB::raw("DATE(NOW())"))
				                    ->get();

				//return $quotes->count();
        if($quotes->isNotEmpty())
					return true;
				else
					return false;
					//return count($quotes);
				} catch ( Illuminate\Database\QueryException $e) {
				    var_dump($e->errorInfo);
					}
    	}
    }

    public static function getHostName($url)
    {
        $parts = parse_url($url);
        if($parts!="" and is_array($parts))
    	   return $parts['host'];
        else
            return $url;
    }

    public function getQuoteProcessed($quotes)
    {
    	if($quotes->isNotEmpty())
    	{
	    	$q = '';
            for($i=0;$i<count($quotes); $i++)
            {
								if(!empty($quotes[$i]->url))
								{
									$purl = $this->getHostName($quotes[$i]->url);
                	$quotes[$i]->purl = $purl;
								}
								else {
									$quotes[$i]->purl = '';
								}
            }
    	}
    	return $quotes;
    }

    public function getViewContent($id)
    {
        $user = Auth::user();

        if($id>0 and $id!="")
        {
            try{
                $quotes = Quotes::where([
                        ['id', '=', $id],
                    ])->get();
                $quotes[0]->purl = $this->getHostName($quotes[0]->url);
                $quotes[0]->isExpired = $this->isQuoteExpired($quotes[0]->id);
                $quotes[0]->ship_status = $this->getShipStatus($quotes[0]->id);
                return $quotes;
            }catch ( Illuminate\Database\QueryException $e) {
                var_dump($e->errorInfo);
            }
        }
    }

    public function getUsernameById($id)
    {
        $user = User::where('id', '=', $id)->get();
        return $user[0]->username;
    }

    public function getUserInfo($id)
    {
        //$userinfo=array('firstname' => '', 'lastname' => '', 'phone' => '');
        //$userinfo = collect(['firstname' => '', 'lastname' => '', 'phone' => '']);
        $userinfo = collect(['firstname', 'lastname', 'phone']);
        $userdata = Users_data::where('uid', '=', $id)->get();
        $userinfo->firstname = "";
        $userinfo->lastname = "";
        $userinfo->phone = "";

        foreach($userdata as $ud)
        {
            if($ud->datakey=='firstname')
                $userinfo->firstname = $ud->datavalue;
            if($ud->datakey=='lastname')
                $userinfo->lastname = $ud->datavalue;
            if($ud->datakey=='phone')
                $userinfo->phone = $ud->datavalue;
        }
        return $userinfo;
    }

    public function getUser($id)
    {
        $customer = new Collection();
        $user = User::where('id', $id)->first();
        $customer = $customer->merge(['username' => $user->username]);
        $customer = $customer->merge(['email' => $user->email]);
        $customer = $customer->merge(['role' => $user->role]);

        $userinfo = $this->getUserInfo($id);
        $customer = $customer->merge(['firstname' => $userinfo->firstname]);
        $customer = $customer->merge(['lastname' => $userinfo->lastname]);
        $customer = $customer->merge(['phone' => $userinfo->phone]);
        return $customer;
    }

    public function getExpiredQuote()
    {
        //SELECT * FROM `yala_quotes` WHERE DATE_ADD(quoted_date, INTERVAL 7 DAY) < DATE(NOW())
        $quotes = Quotes::where(DB::raw("DATE_ADD(quoted_date, INTERVAL 7 DAY)"), '<', DB::raw("DATE(NOW())"))
                                    ->get();

        return $quotes->count();
    }

    public function isQuoteExpired($qid)
    {
        $quotes = Quotes::where('id', '=', $qid)
                            ->where(DB::raw("DATE_ADD(quoted_date, INTERVAL 7 DAY)"), '<', DB::raw("DATE(NOW())"))
                            ->where('quote_status', '<>', 'ordered')
                            ->where('quote_status', '<>', 'complete')
														->where('quote_status', '<>', 'request')
                            ->get();
        if($quotes->count() > 0)
            return 1;
        else
            return 0;
        //return $quotes->count();
    }

    public function getNewOrderID()
    {
        $quote = Quotes::select(DB::raw('max(orderid) as orderid'))->first();
        if($quote->orderid==0)
            return "101";
        else
            return $quote->orderid+1;
        //return print_r($quote);
    }

    public function getAllMessages()
    {
        $comments="";$messages = "";
        if(Auth::check())
        {
            $user = Auth::user();
            if($user->role!='user' and $user->role!="")
            {
                $comments = DB::table('comments')
                            ->join('users', 'comments.uid', '=', 'users.id')
                            ->select('comments.*', 'users.username as username', 'users.role')
                            ->where('users.role', '=', 'user')
                            ->orderBy('comments.created_at', 'DESC')
                            ->get();
                $unreadCommentCount = $comments->count();
                $messages['mCount'] = $unreadCommentCount;
                $messages['comments'] = $comments;
            }
        }
        return $messages;
    }

    public function getUnreadMessages()
    {
        $comments="";$messages = "";
        if(Auth::check())
        {
            $user = Auth::user();
            if($user->role!='user' and $user->role!="")
            {
                $comments = DB::table('comments')
                            ->join('users', 'comments.uid', '=', 'users.id')
                            ->select('comments.*', 'users.username as username')
                            ->where('users.role', '=', 'user')
                            ->where ('comments.is_read',0)
                            ->orderBy('updated_at', 'DESC')
                            ->get();

                $unreadCommentCount = $comments->count();
                $messages['mCount'] = $unreadCommentCount;
                $messages['comments'] = $comments;
            }
        }
        return $messages;
    }

    public function getDiff($dt)
    {
        $current = Carbon::parse($dt);
        return $current->diffForHumans(Carbon::now(), true);
    }

    public function getExchangeRate()
    {
        //$rate['exchange-rate']="";
        $ex = Option::where('var_name', 'exchange-rate')->first();
        //$rate['exchange-rate'] = $ex->var_value;
        return $ex->var_value;
    }

    public function getShipStatus($qid)
    {
        $ship = "";
        $ship = OrderStatus::where('qid', '=', $qid)->first();
        if(!empty($ship))
            return $ship->status;
        else
            return "";
    }

    public function getShipValue($qid)
    {
        $ship = "";
        $ship = OrderStatus::where('qid', '=', $qid)->first();
        if(!empty($ship))
            return $ship;
        else
            return "";
    }

    public function getOrderByUser($uid)
    {
        $qCount = Quotes::where('userid', '=', $uid)
                            ->where('quote_status','=', 'ordered')
                            ->count();

        return $qCount;
    }

    public function getPaymentByUser($uid)
    {
        $qCost = Quotes::selectRaw('SUM(finalcost*exchange_rate) as totalCost')
                            ->where('userid', '=', $uid)
                            ->where('pay_status','=', 'Paid')
                            ->first();

        return $qCost->totalCost;
    }

		/**
		 * updates the updated_at field of the table
		 * parameter: $tbl is table name
		 * $update: field name whose default name will be updated_at
		 */
		public function getTableUpdated($tbl, $update="updated_at")
		{

		}

		public function getQuotesByOption($optname, $optvalue, $userid)
		{
			$quotes = Quotes::where([
								    [$optname, '=', $optvalue],
								    ['userid', '=', $userid]
									])
					->orderBy('request_date','DESC')
					->get();
			return $quotes;
		}

		public function getQuotedByUser($userid)
		{
			try{
				$quotes = Quotes::where('userid', '=', $userid)
									->where(function ($query) {
										$query->where('quote_status', '=', 'accepted')
																		->orWhere('quote_status', '=', 'quoted');
									})
									->orderBy('quoted_date','DESC')
									->get();
				for($i=0;$i<count($quotes); $i++)
				{
					$quotes[$i]->purl = $this->getHostName($quotes[$i]->url);
					$quotes[$i]->isExpired = $this->isQuoteExpired($quotes[$i]->id);
				}
			}catch ( Illuminate\Database\QueryException $e) {
			    var_dump($e->errorInfo);
			}
			return $quotes;
		}

		public function getOrdersByUser($userid)
		{
			try{
				$quotes = DB::table('quotes')
						             ->select('*', DB::raw('count(*) as items'), DB::raw('sum(finalcost) as total'))
						             ->where('userid', '=', $userid)
						             ->whereIn('quote_status', ['ordered', 'complete'])
										 	 	 ->orderBy('ordered_date','DESC')
						             ->groupBy('orderid')
						             ->get();
				for($i=0;$i<count($quotes); $i++)
				{
					$quotes[$i]->isExpired = $this->isQuoteExpired($quotes[$i]->id);
				}
				//$view->with('quotes', $quotes);
			} catch ( Illuminate\Database\QueryException $e) {
			    var_dump($e->errorInfo);
			}
			return $quotes;
		}

		public function getTotalWested()
		{
			return "Here we are";
		}

		public function getTotalCartPrice()
    {

			$total=0;$currency="NRS";
			if(Auth::check())
			{
					$user = Auth::user();
					$carts = Cart::where('userid', '=', $user->id)
													->where('cart_status', '=', 'pending')->get();
			}
			else {
				$sessid = Session::get('cart_name');
	      $carts = Cart::where('sessid', '=', $sessid)
												->where('cart_status', '=', 'pending')->get();
			}

			if(!empty($carts) and count($carts)>0)
			{
	      foreach($carts as $cart)
	      {
					$currency = $cart->currency;
					if($currency=='USD')
						$total = $total + ($cart->quantity * $cart->price * $exRate);
					else
						$total = $total + ($cart->quantity * $cart->price);
	      }
			}
			//return $currency;
			return 'Rs.'.$total;

			if($currency=='NRS')
				return 'Rs.'.$total;
			else
			{
				return 'Rs.'.$total*$exRate;
			}
      	//return '$'.$total;
    }

}
